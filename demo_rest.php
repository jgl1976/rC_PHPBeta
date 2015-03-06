<?php
002
session_start();
003
 
004
function show_accounts($instance_url, $access_token) {
005
    $query = "SELECT Name, Id from Account LIMIT 100";
006
    $url = "$instance_url/services/data/v20.0/query?q=" . urlencode($query);
007
 
008
    $curl = curl_init($url);
009
    curl_setopt($curl, CURLOPT_HEADER, false);
010
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
011
    curl_setopt($curl, CURLOPT_HTTPHEADER,
012
            array("Authorization: OAuth $access_token"));
013
 
014
    $json_response = curl_exec($curl);
015
    curl_close($curl);
016
 
017
    $response = json_decode($json_response, true);
018
 
019
    $total_size = $response['totalSize'];
020
 
021
    echo "$total_size record(s) returned<br/><br/>";
022
    foreach ((array) $response['records'] as $record) {
023
        echo $record['Id'] . ", " . $record['Name'] . "<br/>";
024
    }
025
    echo "<br/>";
026
}
027
 
028
function create_account($name, $instance_url, $access_token) {
029
    $url = "$instance_url/services/data/v20.0/sobjects/Account/";
030
 
031
    $content = json_encode(array("Name" => $name));
032
 
033
    $curl = curl_init($url);
034
    curl_setopt($curl, CURLOPT_HEADER, false);
035
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
036
    curl_setopt($curl, CURLOPT_HTTPHEADER,
037
            array("Authorization: OAuth $access_token",
038
                "Content-type: application/json"));
039
    curl_setopt($curl, CURLOPT_POST, true);
040
    curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
041
 
042
    $json_response = curl_exec($curl);
043
 
044
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
045
 
046
    if ( $status != 201 ) {
047
        die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
048
    }
049
     
050
    echo "HTTP status $status creating account<br/><br/>";
051
 
052
    curl_close($curl);
053
 
054
    $response = json_decode($json_response, true);
055
 
056
    $id = $response["id"];
057
 
058
    echo "New record id $id<br/><br/>";
059
 
060
    return $id;
061
}
062
 
063
function show_account($id, $instance_url, $access_token) {
064
    $url = "$instance_url/services/data/v20.0/sobjects/Account/$id";
065
 
066
    $curl = curl_init($url);
067
    curl_setopt($curl, CURLOPT_HEADER, false);
068
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
069
    curl_setopt($curl, CURLOPT_HTTPHEADER,
070
            array("Authorization: OAuth $access_token"));
071
 
072
    $json_response = curl_exec($curl);
073
 
074
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
075
 
076
    if ( $status != 200 ) {
077
        die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
078
    }
079
 
080
    echo "HTTP status $status reading account<br/><br/>";
081
 
082
    curl_close($curl);
083
 
084
    $response = json_decode($json_response, true);
085
 
086
    foreach ((array) $response as $key => $value) {
087
        echo "$key:$value<br/>";
088
    }
089
    echo "<br/>";
090
}
091
 
092
function update_account($id, $new_name, $city, $instance_url, $access_token) {
093
    $url = "$instance_url/services/data/v20.0/sobjects/Account/$id";
094
 
095
    $content = json_encode(array("Name" => $new_name, "BillingCity" => $city));
096
 
097
    $curl = curl_init($url);
098
    curl_setopt($curl, CURLOPT_HEADER, false);
099
    curl_setopt($curl, CURLOPT_HTTPHEADER,
100
            array("Authorization: OAuth $access_token",
101
                "Content-type: application/json"));
102
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PATCH");
103
    curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
104
 
105
    curl_exec($curl);
106
 
107
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
108
 
109
    if ( $status != 204 ) {
110
        die("Error: call to URL $url failed with status $status, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
111
    }
112
 
113
    echo "HTTP status $status updating account<br/><br/>";
114
 
115
    curl_close($curl);
116
}
117
 
118
function delete_account($id, $instance_url, $access_token) {
119
    $url = "$instance_url/services/data/v20.0/sobjects/Account/$id";
120
 
121
    $curl = curl_init($url);
122
    curl_setopt($curl, CURLOPT_HEADER, false);
123
    curl_setopt($curl, CURLOPT_HTTPHEADER,
124
            array("Authorization: OAuth $access_token"));
125
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
126
 
127
    curl_exec($curl);
128
 
129
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
130
 
131
    if ( $status != 204 ) {
132
        die("Error: call to URL $url failed with status $status, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
133
    }
134
 
135
    echo "HTTP status $status deleting account<br/><br/>";
136
 
137
    curl_close($curl);
138
}
139
?>
140
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
141
<html>
142
    <head>
143
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
144
        <title>REST/OAuth Example</title>
145
    </head>
146
    <body>
147
        <tt>
148
            <?php
149
            $access_token = $_SESSION['access_token'];
150
            $instance_url = $_SESSION['instance_url'];
151
 
152
            if (!isset($access_token) || $access_token == "") {
153
                die("Error - access token missing from session!");
154
            }
155
 
156
            if (!isset($instance_url) || $instance_url == "") {
157
                die("Error - instance URL missing from session!");
158
            }
159
 
160
            show_accounts($instance_url, $access_token);
161
 
162
            $id = create_account("My New Org", $instance_url, $access_token);
163
 
164
            show_account($id, $instance_url, $access_token);
165
 
166
            show_accounts($instance_url, $access_token);
167
 
168
            update_account($id, "My New Org, Inc", "San Francisco",
169
                    $instance_url, $access_token);
170
 
171
            show_account($id, $instance_url, $access_token);
172
 
173
            show_accounts($instance_url, $access_token);
174
 
175
            delete_account($id, $instance_url, $access_token);
176
 
177
            show_accounts($instance_url, $access_token);
178
            ?>
179
        </tt>
180
    </body>
181
</html>
