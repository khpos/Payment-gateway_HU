using System.Text;

namespace KHGatewayClientExample.Communication.DataObjects;

public class EchoRequest : SignBaseRequest
{
    public override string ToSign()
    {
        var sb = new StringBuilder();
        Add(sb, MerchantId);
        Add(sb, Dttm);
        DeleteLast(sb);
        return sb.ToString();
    }
}