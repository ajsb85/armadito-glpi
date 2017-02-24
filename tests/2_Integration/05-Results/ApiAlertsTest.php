<?php

/*
Copyright (C) 2016 Teclib'

This file is part of Armadito Plugin for GLPI.

Armadito Plugin for GLPI is free software: you can redistribute it and/or modify
it under the terms of the GNU Affero General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Armadito Plugin for GLPI is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License
along with Armadito Plugin for GLPI. If not, see <http://www.gnu.org/licenses/>.

**/

class ApiAlertsTest extends CommonTestCase
{
    /**
     * @test
     */
    public function POSTrequests()
    {
        $json_alerts = '{ "alerts" : [';
        $json_alerts .= $this->getJsonForAlert(1483605762, "Pdf.Dropper.Agent-1507034");
        $json_alerts .= $this->getJsonForAlert(1483605770, "Pdf.Dropper.Agent-1507034");
        $json_alerts .= $this->getJsonForAlert(1483605777, "Win.Trojan.Elpapok-1");
        $json_alerts  = rtrim($json_alerts, ",");
        $json_alerts .= '] }';

        $this->insertAlerts($json_alerts, 2, "4C4C4544-0033-4A10-8051-FFFFFFFFFFFF");
        $this->insertAlerts($json_alerts, 3, "4C4C4544-0033-4A10-8051-BBBBBBBBBBBB");
    }

    protected function getJsonForAlert($detection_time, $malware_type)
    {
        return '{
                 "job_id": 1,
                 "name" : "'.$malware_type.'",
                 "filepath" : "/home/malware/X",
                 "action" : "cleaned",
                 "detection_time" : '.$detection_time.'
                },';
    }

    protected function insertAlerts($json_alerts, $agentid, $uuid)
    {
        $json  = '{
          "task": {"obj": '.$json_alerts.',
                   "name":"Alerts",
                   "antivirus": {
                                 "name":"Armadito",
                                 "version":"0.10.2"
                                }
                  },
          "agent_version":"2.3.18",
          "agent_id":'.$agentid.',
          "uuid": "'.$uuid.'"}';

        PluginArmaditoAlert::manageApiRequest($json);
    }
}

