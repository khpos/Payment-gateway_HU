using KHGatewayClientExample.Common;
using KHGatewayClientExample.Communication;
using KHGatewayClientExample.Communication.DataObjects;
using KHGatewayClientExample.Security;
using ManyConsole;
using Newtonsoft.Json;
using NLog;

namespace KHGatewayClientExample.Commands;

public class OneclickInit : ConsoleCommand
{
    private readonly Logger _log = LogManager.GetCurrentClassLogger();

    public OneclickInit()
    {
        IsCommand("ONECLICK_INIT", "Performs ONECLICK_INIT operation.");
        HasRequiredOption("i|initFile=", "InitFile", p => InitFileName = p);
        HasOption("x|origPayId=", "OrigPayId", p => OrigPayId = p);
    }

    private string? InitFileName { get; set; }
    private string? OrigPayId { get; set; }

    public override int Run(string[] remainingArguments)
    {
        var crypto = new Crypto(Constants.MerchantId, Constants.MerchantKeyFileName, Constants.MipsPublicKey);
        var client = new MipsConnector(crypto);
        var initRequest =
            JsonConvert.DeserializeObject<OneclickInitRequest>(
                File.ReadAllText(InitFileName ?? throw new InvalidOperationException()));
        if (null != OrigPayId) initRequest.OrigPayId = OrigPayId;
        var result = client.OneclickInit(initRequest);
        _log.Info("result code: {}, result message: {}, payId: {}, paymentStatus: {}", result.ResultCode,
            result.ResultMessage, result.PayId, result.PaymentStatus);
        return 0;
    }
}