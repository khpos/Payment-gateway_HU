using ManyConsole;
using NLog;

namespace KHGatewayClientExample;

internal class Program
{
    public static int Main(string[] args)
    {
        LogManager.Setup().LoadConfiguration(builder =>
        {
            builder.ForLogger().FilterMinLevel(LogLevel.Debug).WriteToConsole();
        });
        var commands = GetCommands();
        return ConsoleCommandDispatcher.DispatchCommand(commands, args, Console.Out);
    }

    private static IEnumerable<ConsoleCommand> GetCommands()
    {
        return ConsoleCommandDispatcher.FindCommandsInSameAssemblyAs(typeof(Program));
    }
}