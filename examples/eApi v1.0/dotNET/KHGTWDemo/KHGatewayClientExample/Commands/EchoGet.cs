using KHGatewayClientExample.Common;
using KHGatewayClientExample.Communication;
using KHGatewayClientExample.Security;
using ManyConsole;
using NLog;

namespace KHGatewayClientExample.Commands;

public class EchoGet : ConsoleCommand
{
    private readonly Logger _log = LogManager.GetCurrentClassLogger();

    public EchoGet()
    {
        IsCommand("ECHO_GET", "Performs ECHO_GET operation.");
    }

    public override int Run(string[] remainingArguments)
    {
        var crypto = new Crypto(Constants.MerchantId, Constants.MerchantKeyFileName, Constants.MipsPublicKey);
        var client = new MipsConnector(crypto);
        var result = client.EchoGet();
        _log.Info("result code: {}, result message: {}", result.ResultCode, result.ResultMessage);
        return 0;
    }
}