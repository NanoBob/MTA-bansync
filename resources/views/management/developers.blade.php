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

                        <p>
                            This dashboard contains the most important info for your server's management
                        </p>
                        @if($server->server == $server)
                            <h2>API Key</h2>
                            <p>
                                The field below contains your API key. This is what is used for your server only to communicate with bansync.
                                Your API key is private to your server, and should not be disclosed to others.<br>
                                <strong>API Key: </strong>
                                <span id = "key" style="cursor:pointer" onclick=" window.clipboardData.setData('{{ $server->api_key }}')">
                                    {{ $server->api_key }}
                                </span>
                            </p>
                            <h2>Implementing</h2>
                            <p>
                                Implementing Bansync is extremely easy. There are 2 different ways to implement it.
                            </p>
                            <h2>Resource</h2>
                            <p>
                                You can download the bansync resource <a href = "" target="_blank">here</a>.
                                Simply put this in your resources folder on your server, grant it admin rights through
                                the ACL, and start the resource.
                            </p>
                            <h2>Code snippet</h2>
                            <p>
                                If you do not wish to include the resource, you can add the code below to any of your resources.
                                Make sure the resource has admin access though.
                            </p>
                            <pre>
                                <code class="lua atom-one-light">
addEventHandler("onPlayerJoin",getRootElement(),function()
    local player = source
    fetchRemote("https://bans.nanobob.net/api/bans/-1/?api_key={{ $server->api_key }}ip=" .. getPlayerIP(source) .. "&serial=" .. getPlayerSerial(source),
    function(json)
        local result = fromJSON(json)
        local ban = result[1]
        if not ban then
            return
        end
        kickPlayer(player,"You were banned by MTA bansync. Please go to https://bans.nanobob.net/banned to appeal your ban. (Appeal code: " .. ban.appeal_code .. ")")
    end)
end)
                                </code>
                            </pre>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
