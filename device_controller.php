<?php

// no direct access
defined('EMONCMS_EXEC') or die('Restricted access');

function device_controller()
{
    global $session,$route,$mysqli,$user,$redis;

    $result = false;

    require_once "Modules/device/device_model.php";
    $device = new Device($mysqli,$redis);

    if ($route->format == 'html')
    {
        if ($route->action == "view" && $session['write']) {
            $collectorsData = $device->get_active_collectors($session['userid']);
            $devices_templates = $device->get_templates();
            $result = view("Modules/device/Views/device_view.php",array('devices_templates'=>$devices_templates, 'collectorsData' => $collectorsData));
        }
        if ($route->action == 'api') $result = view("Modules/device/Views/device_api.php", array());
    }

    if ($route->format == 'json')
    {
        if ($route->action == 'list') {
            if ($session['userid']>0 && $session['write']) $result = $device->get_list($session['userid']);
        }
        elseif ($route->action == "create") {
            if ($session['userid']>0 && $session['write']) $result = $device->create($session['userid']);
        }
        elseif ($route->action == "listtemplates") {
            if ($session['userid']>0 && $session['write']) $result = $device->get_templates();
        }
        else {
            $deviceid = (int) get('id');
            if ($device->exist($deviceid)) // if the feed exists
            {
                $deviceget = $device->get($deviceid);
                if (isset($session['write']) && $session['write'] && $session['userid']>0 && $deviceget['userid']==$session['userid']) {
                    if ($route->action == "get") $result = $deviceget;
                    if ($route->action == "delete") $result = $device->delete($deviceid);
                    if ($route->action == 'set') $result = $device->set_fields($deviceid, get('fields'));
                    if ($route->action == 'inittemplate') $result = $device->init_template($deviceid);
                }
            }
            else
            {
                $result = array('success'=>false, 'message'=>'Device does not exist');
            }
        }     
    }

    return array('content'=>$result);
}