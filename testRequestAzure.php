<?php
error_reporting(E_ALL);
ini_set('max_execution_time', 300);

$url = 'https://ussouthcentral.services.azureml.net/workspaces/f9520bb6428e4ed685b6c912d415bb23/services/708ccfd6311c45e1baad19f63e4a2cc4/execute?api-version=2.0&details=true';
$api_key = 'p4UVRurc8eYfnQV21KNJNMT3+GtFzoezVq8geXalO7lj/sQDY7AL/JaXV277HoaAkmaxN8CWxfPa298Rril7+Q==';


$data = '{
  "Inputs": {
    "input1": {
      "ColumnNames": [
        "V1"
      ],
      "Values": [
        [
          "561e6f93ce12dcd954656a71"
        ]
      ]
    },
    "input2": {
      "ColumnNames": [
        "sup",
        "con",
        "maxlen"
      ],
      "Values": [
        [
          "0.0003",
          "0.1",
          "3"
        ]
      ]
    }
  },
  "GlobalParameters": {}
}';

$body = json_encode($data);
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Bearer '.$api_key, 'Accept: application/json'));
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response  = curl_exec($ch);
//echo 'Curl error: ' . curl_error($ch);
curl_close($ch);

$ans = json_encode($response);
$rest = substr($response ,11,-1);
echo $rest;
