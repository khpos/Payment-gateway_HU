using System.Text;
using Action = KHGatewayClientExample.Communication.DataObjects.Act.Action;

namespace KHGatewayClientExample.Communication.DataObjects.Response;

public class GooglepayProcessResponse : SignBase
{
    public string? PayId { get; set; }
    public int ResultCode { get; set; }
    public string? ResultMessage { get; set; }
    public long PaymentStatus { get; set; }

    public string? AuthCode { get; set; }
    public string? StatusDetail { get; set; }

    public Action? Actions { get; set; }

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
        if (null != Actions) Add(sb, Actions.ToSign());
        DeleteLast(sb);
        return sb.ToString();
    }
}