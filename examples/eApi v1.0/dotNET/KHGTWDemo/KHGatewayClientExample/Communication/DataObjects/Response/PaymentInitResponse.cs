using System.Text;
using Action = KHGatewayClientExample.Communication.DataObjects.Act.Action;

namespace KHGatewayClientExample.Communication.DataObjects.Response;

public class PaymentInitResponse : SignBase
{
    
    public string? PayId { get; set; }
    public int ResultCode { get; set; }
    public string? ResultMessage { get; set; }
    public int? PaymentStatus { get; set; }
    public string? AuthCode { get; set; }
    public string? StatusDetail { get; set; }

    public Action? Actions { get; } 

    public override string ToSign()
    {
        var sb = new StringBuilder();
        Add(sb, PayId);
        Add(sb, Dttm);
        Add(sb, ResultCode);
        Add(sb, ResultMessage);
        Add(sb, PaymentStatus);
        Add(sb, AuthCode);
        Add(sb, StatusDetail);
        DeleteLast(sb);
        return sb.ToString();
    }
}