using System.Text;
using Action = KHGatewayClientExample.Communication.DataObjects.Act.Action;

namespace KHGatewayClientExample.Communication.DataObjects.Response;

public class ApplepayProcessResponse : SignBase
{
    private string? PayId { get; set; }
    private long ResultCode { get; set; }
    private string? ResultMessage { get; set; }
    private long PaymentStatus { get; set; }
    private string? AuthCode { get; set; }
    private string? StatusDetail { get; set; }

    private Action? Actions { get; set; }

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