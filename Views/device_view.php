<?php
    global $path;

	$devices = array();
        $collectors = array();
	foreach($devices_templates as $key => $value)
	{
		$devices[$key] = ((!isset($value->name) || $value->name == "" ) ? $key : $value->name);
	}
        foreach($collectorsData as $key => $value)
	{
		$collectors[$value->name] = $value->name;
	}
?>

<script type="text/javascript" src="<?php echo $path; ?>Modules/device/Views/device.js"></script>
<script type="text/javascript" src="<?php echo $path; ?>Lib/tablejs/table.js"></script>
<script type="text/javascript" src="<?php echo $path; ?>Lib/tablejs/custom-table-fields.js"></script>
<script type="text/javascript" src="<?php echo $path; ?>Lib/misc/properties_visualizer.js"></script>
<script type="text/javascript" src="<?php echo $path; ?>Lib/bootstrap-multiselect/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="<?php echo $path; ?>Lib/bootstrap-multiselect/css/bootstrap-multiselect.css" type="text/css"/>

<style>
#table input[type="text"] {
  width: 88%;
}
</style>

<div>
    <div id="apihelphead" style="float:right;"><a href="api"><?php echo _('Devices Help'); ?></a></div>
    <div id="localheading"><h2><?php echo _('Devices'); ?></h2></div>

    <div id="table"><div align='center'><?php echo _("loading..."); ?></div></div>
	
    <div id="nodevices" class="hide">
        <div class="alert alert-block">
            <h4 class="alert-heading"><?php echo _('No devices'); ?></h4><br>
            <p><?php echo _('There are no devices configured. Please add a new device.'); ?></p>
        </div>
    </div>

    <div id="bottomtoolbar"><hr>
        <button id="addnewdevice" class="btn btn-small" >&nbsp;<i class="icon-plus-sign" ></i>&nbsp;<?php echo _('New device'); ?></button>
    </div>
</div>

<div id="myModal" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel"><?php echo _('Delete device'); ?></h3>
    </div>
    <div class="modal-body">
        <p><?php echo _('Deleting a device is permanent.'); ?>
           <br><br>
           <?php echo _('If this device is active and is using a device key, it will no longer be able to post data.'); ?>
		   <br><br>
		   <?php echo _('Inputs and Feeds that this device uses are not deleted and all historic data is kept. To remove them, deleted manualy afterwards.'); ?>
           <br><br>
           <?php echo _('Are you sure you want to delete?'); ?>
        </p>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo _('Cancel'); ?></button>
        <button id="confirmdelete" class="btn btn-primary"><?php echo _('Delete permanently'); ?></button>
    </div>
</div>

<div id="initdeviceModal" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="initdeviceModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="initdeviceModalLabel"><?php echo _('Initialize device'); ?></h3>
    </div>
    <div class="modal-body">
        <p><?php echo _('The selected inputs and associated feeds will be automaticaly created.'); ?>
		   <br><br>
		   <?php echo _('Make sure the selected device node and type are correcly configured before proceding.'); ?>
		   <br>
		   <?php echo _('Initializing a device usualy should only be done once on installation.'); ?>
		   <br>
           <?php echo _('If the node name already exists, new default inputs and feeds will be added.'); ?>
		   <br><br>
        </p><br>
            <div id="deviceInputs">
                <label for="inputSelection"><?php echo _('Inputs'); ?></label>
                <select id="inputSelection" multiple="multiple"></select>  
            </div><br>
            <div id="deviceSettings">
                <label><b><?php echo _('Settings');?></b></label>
                <div id="deviceSettingsContent"></div>
            </div>
    </div>
    <div class="modal-footer">
        <button id="canceldevicesettings" class="btn" data-dismiss="modal" aria-hidden="true"><?php echo _('Cancel'); ?></button>
        <button id="savedevicesettings" class="btn btn-primary"><?php echo _('Save Settings'); ?></button>
        <button id="confirminitdevice" class="btn btn-primary"><?php echo _('Initialize (create inputs and feeds)'); ?></button>   
    </div>
</div>

<script>
  var path = "<?php echo $path; ?>";
  var devices = <?php echo json_encode($devices); ?>;
  var collectorsData = <?php echo json_encode($collectorsData); ?>;
  var collectors = <?php echo json_encode($collectors); ?>; 
  var devicesTemplates = <?php echo json_encode($devices_templates); ?>;
  // Extend table library field types
  for (z in customtablefields) table.fieldtypes[z] = customtablefields[z];
  table.element = "#table";
  //table.groupby = 'description';
  table.deletedata = false;
  table.fields = {
    //'id':{'type':"fixed"},
    'name':{'title':'<?php echo _("Name"); ?>','type':"text"},
    'description':{'title':'<?php echo _('Location'); ?>','type':"text"},
    'nodeid':{'title':'<?php echo _("Node"); ?>','type':"text"},
    'type':{'title':'<?php echo _("Type"); ?>','type':"select",'options':devices},
    'devicekey':{'title':'<?php echo _('Device access key'); ?>','type':"text"},
    'time':{'title':'<?php echo _("Updated"); ?>', 'type':"updated"},
    'active':{'title':'<?php echo _("Active"); ?>', 'type':"icon", 'trueicon':"icon-ok", 'falseicon':"icon-remove"},
    'collector':{'title':'<?php echo _("Collector"); ?>', 'type':"select", 'options':collectors},
    //'public':{'title':"<?php echo _('tbd'); ?>", 'type':"icon", 'trueicon':"icon-globe", 'falseicon':"icon-lock"},
    // Actions
    'edit-action':{'title':'', 'type':"edit", 'tooltip':"<?php echo _('Edit'); ?>"},
    'delete-action':{'title':'', 'type':"delete", 'tooltip':"<?php echo _('Delete'); ?>"},
    //'view-action':{'title':'', 'type':"iconbasic", 'icon':'icon-wrench'},
    'create-action':{'title':'', 'type':"iconbasic", 'icon':'icon-file', 'tooltip':"<?php echo _('Initialize device'); ?>"}
  }

  update();

  function update(){
    var requestTime = (new Date()).getTime();
    $.ajax({ url: path+"device/list.json", dataType: 'json', async: true, success: function(data, textStatus, xhr) {
      table.timeServerLocalOffset = requestTime-(new Date(xhr.getResponseHeader('Date'))).getTime(); // Offset in ms from local to server time
      table.data = data;
/*
	  for (d in data) {
        if (data[d]['own'] != true){ 
          data[d]['#READ_ONLY#'] = true;  // if the data field #READ_ONLY# is true, the fields type: edit, delete will be ommited from the table row and icon type will not update when clicked.
        }
      }
*/
      table.draw();
      if (table.data.length !== 0) {
        $("#nodevices").hide();
        $("#localheading").show();
        $("#apihelphead").show();
      } else {
        $("#nodevices").show();
        $("#localheading").hide();
        $("#apihelphead").hide();
      }
    }});
  }

  var updater;
  var deviceTemplate = null;
  var settingInputs;
  var rowid;
  var multiOptions = {};
  multiOptions.nonSelectedText = '<?php echo _('No input selected');?>';
  multiOptions.selectAllValue = 'select-all-value';
  multiOptions.selectAllText = '<?php echo _('Select all');?>';
  multiOptions.includeSelectAllOption = true;
  multiOptions.enableFiltering = true;
  multiOptions.enableCaseInsensitiveFiltering = true;
  multiOptions.filterBehavior = "value";
  multiOptions.filterPlaceholder = '<?php echo _('Search for inputs');?>';
  var select;
  
  $(document).ready(function(){
    select = $('#inputSelection');
  });
  
  function updaterStart(func, interval)
  {
    clearInterval(updater);
    updater = null;
    if (interval > 0) updater = setInterval(func, interval);
  }
  updaterStart(update, 10000);

  $("#table").bind("onEdit", function(e){
    updaterStart(update, 0);
  });

  $("#table").bind("onSave", function(e,id,fields_to_update){
    device.set(id,fields_to_update);
  });

  $("#table").bind("onResume", function(e){
    updaterStart(update, 10000);
  });

  $("#table").bind("onDelete", function(e,id,row){
    $('#myModal').modal('show');
    $('#myModal').attr('deviceid',id);
    $('#myModal').attr('devicerow',row);
  });

  $("#confirmdelete").click(function()
  {
    var id = $('#myModal').attr('deviceid');
    var row = $('#myModal').attr('schedulerow');
    device.remove(id);
    table.remove(row);
    update();

    $('#myModal').modal('hide');
  });

  $("#addnewdevice").click(function(){
    $.ajax({ url: path+"device/create.json", success: function(data){update();} });
  });
 
  $("#table").on('click', '.icon-file', function() {
    $('#deviceSettingsContent').html('');
    $('#inputSelection option').remove();
    select.multiselect('destroy');
    var type = table.data[$(this).attr('row')]['type'];
    if(type !== ''){
      $.each(devicesTemplates, function(name, element){
        if(type === name){
          deviceTemplate = element;
          return false;
        }
      });
      if(deviceTemplate !== null){
        rowid = $(this).attr('row');
        var container = $('#deviceSettingsContent');
	var props = table.data[rowid]['properties'];
	if(props === ""){
	  props = {};
	}else{
          props = JSON.parse(props);
	}
        if(deviceTemplate.properties){
          var visualizer = new PropertiesVisualizer();
          settingInputs = visualizer.visualize(deviceTemplate.properties, container, props);
        }
        if(deviceTemplate.inputs){
          $.each(deviceTemplate.inputs, function(index, element){
            var display = false;
            if(typeof element.active === "string"){
              display = element.active === "1";
            } else{
              display = true;
            }
            if(display){
              var opt = $("<option></option>");
              opt.val(element.name);
              if(element.unit && element.unit !== ""){
                opt.text(element.name + " (" + element.unit + ")");
              } else{
                opt.text(element.name);
              }
              select.append(opt);
            }
          });
          
          select.multiselect(multiOptions);
        }
        $('#initdeviceModal').modal('show');
        $('#initdeviceModal').attr('deviceid',table.data[$(this).attr('row')]['id']);
      }
    } else{
      alert('<?php echo _('No type selected'); ?>');
    }
  });
  
  $("#confirminitdevice").click(function()
  {
    var selectedOtions = $('#inputSelection option:selected');
    var selectedCount = selectedOtions.length;
    if(selectedCount > 0){
      var id = $('#initdeviceModal').attr('deviceid');
      var inputsArray = [];
      selectedOtions.each(function(index, item){
        if(item.value !== multiOptions.selectAllValue){
          inputsArray.push(item.value);
        }
      });
      var inputs = inputsArray.join();
      var result = device.inittemplate(id, inputs);
      alert(result['message']);
      $('#initdeviceModal').modal('hide');
    } else{
      alert('<?php echo _('No inputs selected'); ?>');
    }
  });
  
  $("#savedevicesettings").click(function()
  {
    var id = $('#initdeviceModal').attr('deviceid');
    var data = {'properties':{}};
    $.each(settingInputs, function(key, value){
      var id = value.attr("id");
      var val = value.val();
      var dataType = "";
      $.each(deviceTemplate.properties, function(key, value){
	if(value.name === id){
	  dataType = value.dataType;
          return false;
	}
      });
      if(dataType === "number"){
        data.properties[id] = parseFloat(val);
      }else{
        data.properties[id] = val;
      }
    });
    if(!$.isEmptyObject(data.properties)){
      device.set(id, data);
      //alert(result["message"]);
    }
    $('#initdeviceModal').modal('hide');
    var newProps = JSON.stringify(data.properties);
    table.data[rowid]['properties'] = newProps;
  });
  


</script>
