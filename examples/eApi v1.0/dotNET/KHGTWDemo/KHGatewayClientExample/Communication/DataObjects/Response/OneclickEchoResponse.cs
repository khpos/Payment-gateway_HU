using System.Text;
using KHGatewayClientExample.Communication.DataObjects.Ext;

namespace KHGatewayClientExample.Communication.DataObjects.Response;

public class OneclickEchoResponse : SignBase
{
    public string? OrigPayId { get; set; }
    public int ResultCode { get; set; }
    public string? ResultMessage { get; set; }

    public List<Extension>? Extensions { get; set; }

    public override string ToSign()
    {
        var sb = new StringBuilder();
        Add(sb, OrigPayId);
        Add(sb, Dttm);
        Add(sb, ResultCode);
        Add(sb, ResultMessage);
        DeleteLast(sb);
        return sb.ToString();
    }
}