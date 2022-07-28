using KHGatewayClientExample.Common;
using KHGatewayClientExample.Communication;
using KHGatewayClientExample.Security;
using ManyConsole;
using NLog;

namespace KHGatewayClientExample.Commands;

public class EchoPost : ConsoleCommand
{
    private readonly Logger _log = LogManager.GetCurrentClassLogger();

    public EchoPost()
    {
        IsCommand("ECHO_POST", "Performs ECHO_POST operation.");
    }

    public override int Run(string[] remainingArguments)
    {
        var crypto = new Crypto(Constants.MerchantId, Constants.MerchantKeyFileName, Constants.MipsPublicKey);
        var client = new MipsConnector(crypto);
        var result = client.EchoPost();
        _log.Info("result code: {}, result message: {}", result.ResultCode, result.ResultMessage);
        return 0;
    }
}