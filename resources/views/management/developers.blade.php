@extends('management/layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ env("APP_NAME") }}</div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if($server->server == $server)
                            <h2>API Key</h2>
                            <p>
                                The field below contains your API key. This is what is used for your server only to communicate with bansync.
                                Your API key is private to your server, and should not be disclosed to others.<br>
                                <strong>API Key: </strong>
                                <span id = "key" style="cursor:pointer" onclick="$(this).select(); document.execCommand('copy')">
                                    {{ $server->api_key }}
                                </span>
                            </p>
                            <h2>Implementing</h2>
                            <p>
                                Implementing Bansync is extremely easy.
                                In order to implement it on your server you have to add the code below to any of your resources.
                                Make sure the resource has admin access though.
                            </p>
                            <pre>
                                <code class="lua atom-one-light">local function handleJoin(player)
    local player = source or player
	local url = "https://bans.nanobob.net/api/bans/find/?api_key={{ $server->api_key }}&ip=" .. getPlayerIP(player) .. "&serial=" .. getPlayerSerial(player)
	fetchRemote(url,
		function(json,statusCode)
			if (json == "ERROR") then
				return outputDebugString("HTTP Status code: " .. statusCode)
			end
			local result = fromJSON(json)
			local ban = result
			if not ban then
				return
			end
			kickPlayer(player,"https://bans.nanobob.net/banned (Appeal code: " .. ban.appeal_code .. ")")
		end)

end
addEventHandler("onPlayerJoin",getRootElement(),handleJoin)

for _,player in pairs(getElementsByType("player")) do
	handleJoin(player)
end</code>
                            </pre>
                            <h2>Documentation</h2>
                            <p>
                                If for whatever reason you want to manually implement bansync to make use of the API documentation is below.
                                GET requests return json encoded strings as response, POST requests will return a 200 status code if successful.
                                A 403 status code will be returned if the API key does not match any servers.
                            </p>
                            <h3>Find</h3>
                            <p>
                                Find will see if there is a ban in the database for a user, and reference this to your server's settings<br>
                                <strong>Endpoint:</strong> /api/bans/find<br>
                                <strong>Method:</strong> get<br>
                                <strong>parameters:</strong><br>
                            </p>
                                <table class = "table">
                                    <tr>
                                        <th>Key</th>
                                        <th>Description</th>
                                    </tr>
                                    <tr>
                                        <td>api_key</td>
                                        <td>Your unique API key, found above on this page</td>
                                    </tr>
                                    <tr>
                                        <td>ip</td>
                                        <td>The IP of the user to check for a ban</td>
                                    </tr>
                                        <td>serial</td>
                                        <td>The serial of the user to check for a ban</td>
                                    </tr>
                                </table>
                            <h3>Response</h3>
                            <p>
                                The response contains the details on any bans that match the IP or serial, and are enforced according to your server's settings
                            </p>
                            <pre>
                                <code class = "json">[
    {
        "id":1,
        "serial":"AB5ED8C81A618F",
        "ip":"192.168.1.1",
        "name":"Hank",
        "details":"Hank used S0beit",
        "banned_until":"2017-10-11 15:03:27",
        "appeal_code":"RQTRGUPL",
        "created_at":"2017-10-11 06:01:19",
        "banner":{
            "name":"NanoBob",
            "type":"admin",
            "verified":1,
            "serverName":"SAES:RPG"
        },
        "reason":{
            "reason":"Cheating \/ hacking"
        }
    }
] </code>
                            </pre>
                            <h3>Index</h3>
                                <p>
                                    The index will return all bans enforced by your server.<br>
                                    <strong>Endpoint:</strong> /api/bans<br>
                                    <strong>Method:</strong> get<br>
                                    <strong>parameters:</strong><br>
                                </p>
                                <table class = "table">
                                    <tr>
                                        <th>Key</th>
                                        <th>Description</th>
                                    </tr>
                                    <tr>
                                        <td>api_key</td>
                                        <td>Your unique API key, found above on this page</td>
                                    </tr>
                                </table>
                                <h3>Response</h3>
                                <p>
                                    The response contains the details on any bans that are enforced according to your server's settings.
                                    The sample response below contains an example of a server enforcing two bans
                                </p>
                                <pre>
                                <code class = "json">[
    {
        "id":1,
        "serial":"AB5ED8C81A618F",
        "ip":"192.168.1.1",
        "name":"Hank",
        "details":"Hank used S0beit",
        "banned_until":"2017-10-11 15:03:27",
        "appeal_code":"RQTRGUPL",
        "created_at":"2017-10-11 06:01:19",
        "banner":{
            "name":"NanoBob",
            "type":"admin",
            "verified":1,
            "serverName":"SAES:RPG"
        },
        "reason":{
            "reason":"Cheating \/ hacking"
        }
    },
    {
        "id":2,
        "serial":"NDESA#7wfKFYGAWusGSwukcy",
        "ip":"1.1.1.1",
        "name":"Dennis",
        "details":"He used wallhacks and client side skin mods with smaller hitboxes.",
        "banned_until":"2020-01-01 12:00:00",
        "appeal_code":"Z2OJUA5E",
        "created_at":"2017-10-11 16:00:00",
        "banner":{
            "name":"SAES:RPG",
            "type":"server",
            "verified":1,
            "serverName":"SAES:RPG"
        },
        "reason":{
            "reason":"Cheating \/ hacking"
        }
    }
]</code>
                            </pre>
                            <h3>Create</h3>
                            <p>
                                The create method will add a new ban to the database<br>
                                <strong>Endpoint:</strong> /api/bans/create<br>
                                <strong>Method:</strong> post<br>
                                <strong>parameters:</strong><br>
                            </p>
                            <table class = "table">
                                <tr>
                                    <th>Key</th>
                                    <th>Description</th>
                                </tr>
                                <tr>
                                    <td>api_key</td>
                                    <td>Your unique API key, found above on this page</td>
                                </tr>
                                <tr>
                                    <td>serial</td>
                                    <td>The serial of the player to ban</td>
                                </tr>
                                <tr>
                                    <td>ip</td>
                                    <td>The ip of the player to ban</td>
                                </tr>
                                <tr>
                                    <td>reason</td>
                                    <td>The numeric ID of the ban reason (default: 6)</td>
                                </tr>
                                <tr>
                                    <td>details</td>
                                    <td>The details on why the player is banned (default: N/A)</td>
                                </tr>
                                <tr>
                                    <td>banned_until</td>
                                    <td>Timestamp until player unban in YYYY-mm-dd hh:mm format. (Default: current time + 100 years)</td>
                                </tr>
                            </table>
                            <h3>Response</h3>
                            <p>
                                The response will be a status code 200 if successful, any other status codes mean failure.
                            </p>

                                <h3>Destroy</h3>
                                <p>
                                    The destroy method will remove a ban from the database<br>
                                    <strong>Endpoint:</strong> /api/bans/destroy<br>
                                    <strong>Method:</strong> post<br>
                                    <strong>parameters:</strong><br>
                                </p>
                                <table class = "table">
                                    <tr>
                                        <th>Key</th>
                                        <th>Description</th>
                                    </tr>
                                    <tr>
                                        <td>api_key</td>
                                        <td>Your unique API key, found above on this page</td>
                                    </tr>
                                    <tr>
                                        <td>serial</td>
                                        <td>The serial of the player to unban</td>
                                    </tr>
                                    <tr>
                                        <td>ip</td>
                                        <td>The ip of the player to unban</td>
                                    </tr>
                                </table>
                                <h3>Response</h3>
                                <p>
                                    The response will be a status code 200 if successful, any other status codes mean failure.
                                </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
