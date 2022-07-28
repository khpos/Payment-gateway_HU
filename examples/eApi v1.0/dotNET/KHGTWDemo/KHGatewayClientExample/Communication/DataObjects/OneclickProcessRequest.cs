using System.Text;
using KHGatewayClientExample.Communication.DataObjects.Act;
using Newtonsoft.Json;

namespace KHGatewayClientExample.Communication.DataObjects;

public class OneclickProcessRequest : SignBaseRequest
{
    [JsonProperty("payId", Required = Required.Always)]
    public string? PayId { get; set; }

    [JsonProperty("fingerprint")] public AuthData? Fingerprint { get; set; }


    public override string ToSign()
    {
        var sb = new StringBuilder();
        Add(sb, MerchantId);
        Add(sb, PayId);
        Add(sb, Dttm);
        if (null != Fingerprint) Add(sb, Fingerprint.ToSign());
        DeleteLast(sb);
        return sb.ToString();
    }
}