using Newtonsoft.Json;

namespace KHGatewayClientExample.Communication.DataObjects;

public abstract class SignBase : ApiBase
{
    [JsonProperty("dttm")] public string? Dttm { get; set; }

    [JsonProperty("signature")] public string? Signature { get; set; }

    public abstract string ToSign();
}