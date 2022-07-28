﻿using KHGatewayClientExample.Common;
using KHGatewayClientExample.Communication;
using KHGatewayClientExample.Communication.DataObjects;
using KHGatewayClientExample.Communication.DataObjects.Act;
using KHGatewayClientExample.Security;
using ManyConsole;
using NLog;

namespace KHGatewayClientExample.Commands;

public class OneclickProcess : ConsoleCommand
{
    private readonly Logger _log = LogManager.GetCurrentClassLogger();

    public OneclickProcess()
    {
        IsCommand("ONECLICK_PROCESS", "Performs ONECLICK_PROCESS operation.");
        HasRequiredOption("p|payId=", "PayId obtained from ONECLICK_INIT", p => PayId = p);
    }

    private string? PayId { get; set; }

    public override int Run(string[] remainingArguments)
    {
        var crypto = new Crypto(Constants.MerchantId, Constants.MerchantKeyFileName, Constants.MipsPublicKey);
        var client = new MipsConnector(crypto);
        var result = client.OneclickProcess(PayId ?? throw new InvalidOperationException(), CreateTestFingerprint());
        _log.Info("result code: {}, result message: {}, payId: {}, paymentStatus: {}", result.ResultCode,
            result.ResultMessage, result.PayId, result.PaymentStatus);
        return 0;
    }

    private static AuthData CreateTestFingerprint()
    {
        var fingerprint = new AuthData
        {
            Browser = new Auth3dsBrowser
            {
                JavaEnabled = false,
                Language = "cs-CZ",
                ColorDepth = 24,
                ScreenHeight = 720,
                ScreenWidth = 1280,
                Timezone = -60,
                JavascriptEnabled = true,
                ChallengeWindowSize = "01",
                AcceptHeader = "application/json, text/plain, */*",
                UserAgent =
                    "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36"
            }
        };
        return fingerprint;
    }
}