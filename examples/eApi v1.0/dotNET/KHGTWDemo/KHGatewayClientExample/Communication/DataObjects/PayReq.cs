﻿using System.Text;
using Newtonsoft.Json;

namespace KHGatewayClientExample.Communication.DataObjects;

public class PayReq : SignBaseRequest
{

    [JsonProperty("payId", Required = Required.Always)]
    public string? PayId { get; set; }

    public override string ToSign()
    {
        var sb = new StringBuilder();
        Add(sb, MerchantId);
        Add(sb, PayId);
        Add(sb, Dttm);
        DeleteLast(sb);
        return sb.ToString();
    }
}