using System.Text;
using Newtonsoft.Json;

namespace KHGatewayClientExample.Communication.DataObjects;

public class Customer : ApiBase
{
    [JsonProperty("name")] public string? Name { get; set; }

    [JsonProperty("email")] public string? Email { get; set; }

    [JsonProperty("homePhone")] public string? HomePhone { get; set; }

    [JsonProperty("workPhone")] public string? WorkPhone { get; set; }

    [JsonProperty("mobilePhone")] public string? MobilePhone { get; set; }

    [JsonProperty("account")] public Account? Account { get; set; }

    [JsonProperty("login")] public Login? Login { get; set; }


    public string? ToSign()
    {
        var sb = new StringBuilder();
        Add(sb, Name);
        Add(sb, Email);
        Add(sb, HomePhone);
        Add(sb, WorkPhone);
        Add(sb, MobilePhone);
        if (Account != null) Add(sb, Account.ToSign());
        if (Login != null) Add(sb, Login.ToSign());
        DeleteLast(sb);
        return sb.ToString();
    }
}

public class Account : SignBase
{
    [JsonProperty("createdAt")] public string? CreatedAt { get; set; }

    [JsonProperty("changedAt")] public string? ChangedAt { get; set; }

    [JsonProperty("changedPwdAt")] public string? ChangedPwdAt { get; set; }

    [JsonProperty("orderHistory")] public int? OrderHistory { get; set; }

    [JsonProperty("paymentsDay")] public int? PaymentsDay { get; set; }

    [JsonProperty("paymentsYear")] public int? PaymentsYear { get; set; }

    [JsonProperty("oneclickAdds")] public int? OneclickAdds { get; set; }

    [JsonProperty("suspicious")] public bool? Suspicious { get; set; }


    public override string ToSign()
    {
        var sb = new StringBuilder();
        Add(sb, CreatedAt);
        Add(sb, ChangedAt);
        Add(sb, ChangedPwdAt);
        Add(sb, OrderHistory);
        Add(sb, PaymentsDay);
        Add(sb, PaymentsYear);
        Add(sb, OneclickAdds);
        Add(sb, Suspicious);
        DeleteLast(sb);
        return sb.ToString();
    }
}

public class Login : SignBase
{
    //static : ApiBase Signable

    [JsonProperty("auth")] public string? Auth { get; set; }

    [JsonProperty("authAt")] public string? AuthAt { get; set; }

    [JsonProperty("authData")] public string? AuthData { get; set; }


    public override string ToSign()
    {
        var sb = new StringBuilder();
        Add(sb, Auth);
        Add(sb, AuthAt);
        Add(sb, AuthData);
        DeleteLast(sb);
        return sb.ToString();
    }
}
