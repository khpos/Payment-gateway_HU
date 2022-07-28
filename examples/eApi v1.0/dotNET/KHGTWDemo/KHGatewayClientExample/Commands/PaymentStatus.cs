using KHGatewayClientExample.Common;
using KHGatewayClientExample.Communication;
using KHGatewayClientExample.Communication.DataObjects;
using KHGatewayClientExample.Communication.DataObjects.Act;
using KHGatewayClientExample.Security;
using ManyConsole;
using NLog;

namespace KHGatewayClientExample.Commands;

public class PaymentStatus : ConsoleCommand
{
    private readonly Logger _log = LogManager.GetCurrentClassLogger();

    public PaymentStatus()
    {
        IsCommand("PAYMENT_STATUS", "Performs PAYMENT_STATUS operation.");
        HasRequiredOption("p|payId=", "PayId obtained from PAYMENT_INIT", p => PayId = p);
    }

    private string? PayId { get; set; }

    public override int Run(string[] remainingArguments)
    {
        var crypto = new Crypto(Constants.MerchantId, Constants.MerchantKeyFileName, Constants.MipsPublicKey);
        var client = new MipsConnector(crypto);
        var result = client.PaymentStatus(PayId ?? throw new InvalidOperationException());
        _log.Info("result code: {}, result message: {}, payId: {}, paymentStatus: {}", result.ResultCode,
            result.ResultMessage, result.PayId, result.PaymentStatus);
        return 0;
    }
}