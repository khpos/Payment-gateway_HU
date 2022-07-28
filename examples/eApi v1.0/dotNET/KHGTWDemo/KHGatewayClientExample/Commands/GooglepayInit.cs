using KHGatewayClientExample.Common;
using KHGatewayClientExample.Communication;
using KHGatewayClientExample.Communication.DataObjects;
using KHGatewayClientExample.Security;
using ManyConsole;
using Newtonsoft.Json;
using NLog;

namespace KHGatewayClientExample.Commands;

public class GooglepayInit : ConsoleCommand
{
    private readonly Logger _log = LogManager.GetCurrentClassLogger();

    public GooglepayInit()
    {
        IsCommand("GOOGLEPAY_INIT", "Performs GOOGLEPAY_INIT operation.");
        HasRequiredOption("i|initFile=", "InitFile", p => InitFileName = p);
        HasOption("t|payLoad=", "PayLoad", p => PayLoad = p);
    }

    private string? PayLoad { get; set; }
    private string? InitFileName { get; set; }

    public override int Run(string[] remainingArguments)
    {
        var crypto = new Crypto(Constants.MerchantId, Constants.MerchantKeyFileName, Constants.MipsPublicKey);
        var client = new MipsConnector(crypto);
        var initRequest =
            JsonConvert.DeserializeObject<GooglepayInitRequest>(
                File.ReadAllText(InitFileName ?? throw new InvalidOperationException()));
        if (null != PayLoad) initRequest.Payload = PayLoad;

        var result = client.GooglepayInit(initRequest);
        _log.Info("result code: {}, result message: {}, payId: {}, paymentStatus: {}", result.ResultCode,
            result.ResultMessage, result.PayId, result.PaymentStatus);
        return 0;
    }
}