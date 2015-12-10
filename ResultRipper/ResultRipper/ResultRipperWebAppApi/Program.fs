namespace rally

module Types = 
    [<CLIMutable>]
    type ComptitorEvent = {
        mutable carNumber : string
        driver : string
        codriver : string
        address : string
        car : string
        classEntered : string
        mutable category : string
        stageData : seq<float * float>
    }

//
//module Logger = 
//
//    open System
//    open System.IO
//
//    let WriteToFile(format:string) =   
//        use streamWriter = new StreamWriter("C:\Users\soundstore1\Desktop\logger.log", true)
//        //let file = FileInfo("C:\Users\soundstore1\Desktop\logger.log")
//        streamWriter.WriteLine(format)
//
//    type Level =
//        | Error = 0
//        | Warn = 1
//        | Info = 2
//        | Debug = 3
//
//    let LevelToString level =
//      match level with
//        | Level.Error -> "Error"
//        | Level.Warn -> "Warn"
//        | Level.Info -> "Info"
//        | Level.Debug -> "Debug"
//        | _ -> "Unknown"
//
//    /// The current log level.
//    let mutable current_log_level = Level.Debug
//
//    /// The inteface loggers need to implement.
//    type ILogger = abstract Log : Level -> string -> unit
//
//    /// Writes to Console.
//    let ConsoleLogger = { 
//        new ILogger with
//            member __.Log level format =
//                printfn "[%s] [%A] %s" (LevelToString level) System.DateTime.Now format
//     }
//
//    /// Writes to File.
//    let FileLogger = { 
//        new ILogger with
//            member __.Log level format =
//                WriteToFile(sprintf "[%s] [%A] %s" (LevelToString level) System.DateTime.Now format)
//     }
//
//    /// Defines which logger to use.
//    let DefaultLogger = [| FileLogger; ConsoleLogger |]
//
//    /// Logs a message with the specified logger.
//    let logUsing (logger: ILogger) = logger.Log
//
//    /// Logs a message using the default logger.
//    let log level message = 
//        DefaultLogger |> Array.map(fun (logger:ILogger) -> logUsing logger level message) |> ignore

module Database = 
    
    open FSharp.Data
    open Npgsql
    //open Logger
    open System

    type Simple = JsonProvider<""" {
        "name" : "Westlodge Fastnet Rally 2015",
        "startdate" : "2015-10-24",
        "finishdate" : "2015-10-25",
        "surface" : "Tarmac",
        "image": "image.jpg",
        "service" : [3,6],
        "endofday" : [10],
        "category": [
            {
                "type": "Main Field",
                "class": "M7"
            },
            {
                "type": "Historics",
                "class": "J3"
            },
            {
                "type": "Juniors",
                "class": "J1"
            }
        ]
    } """>
    
    let connectionString = "Server = 91.212.182.223; Port = 5432; Database = rallyres_db2015; User Id = rallyres_admin; Password = y6j5atu5 ; CommandTimeout = 40; SSL=True; Sslmode=require;"

    let GetId connection =
        let idQuery = sprintf "SELECT MAX(\"Id\") FROM \"Entrant\""
        let command = new NpgsqlCommand(idQuery, connection)
        let dataReader = command.ExecuteScalar().ToString()
        match dataReader with
        | "" -> 1
        | _ -> Convert.ToInt32(dataReader) + 1
    
    let GetCatogeries connection eventId =
        let idQuery = sprintf "SELECT * FROM \"Event_Individual\" WHERE \"Id\" = %i" eventId
        let command = new NpgsqlCommand(idQuery, connection)
        let dataReader = command.ExecuteReader()
        let json = 
            [while dataReader.Read() do
                yield dataReader.GetString(1)]
        dataReader.Close()
        let simple = Simple.Parse(json.Head)
        let dictonary = 
           simple.Category
           |> Seq.map(fun item -> item.Class, item.Type)
           |> dict
        dictonary


    let testDB(competitor:Types.ComptitorEvent, connection, eventId, classDict:System.Collections.Generic.IDictionary<string,string> ) =
        printfn "%s" (competitor.driver)

        let stageTimes = 
            try
                let stageAndPenaltyTime =
                    competitor.stageData
                    |> Seq.map (fun (stage, penalty)-> "{" + stage.ToString() + ", " + penalty.ToString() + "}")
                    |> Seq.reduce (fun state item -> state + ", " + item)
                "{" + stageAndPenaltyTime.ToString() + "}"
            with
            | :? System.InvalidOperationException as ex -> 
                "{}"

        let superRally (entrant:Types.ComptitorEvent) = 
            entrant.carNumber.Contains("R")

        let containsNumber number list = 
            list
            |> List.exists (fun elem -> elem = number)

        let parseCarNumber (entrant:Types.ComptitorEvent) = 
            entrant.carNumber <- entrant.carNumber.Trim().ToString()
            match entrant.carNumber.ToString().Contains("J") || entrant.carNumber.Trim().ToString().Contains("H") with
            | true when entrant.carNumber.ToString().Length = 3 && entrant.carNumber.ToString().Contains("J") -> entrant.carNumber.ToString().Replace("J","3")
            | true when entrant.carNumber.ToString().Length = 2 && entrant.carNumber.ToString().Contains("J") -> entrant.carNumber.ToString().Replace("J","30")
            | true when entrant.carNumber.ToString().Length = 3 && entrant.carNumber.ToString().Contains("H") -> entrant.carNumber.ToString().Replace("H","2")
            | true when entrant.carNumber.ToString().Length = 2 && entrant.carNumber.ToString().Contains("H") -> entrant.carNumber.ToString().Replace("H","20")
            | _ -> entrant.carNumber

        let insert() =
            let x = parseCarNumber competitor
            competitor.carNumber <- x
            competitor.category <- classDict.[competitor.classEntered.Trim()]
            let insertString = sprintf "INSERT INTO \"Entrant\" VALUES ('%i',%i,'%s','%s','%s','%s','%s','%s','%s','%b')" (eventId)
                                                                                                                           (Convert.ToInt32(competitor.carNumber.Replace("R","").Trim())) 
                                                                                                                           (competitor.driver.Replace("'"," ")) 
                                                                                                                           (competitor.codriver.Replace("'"," ")) 
                                                                                                                           (competitor.address) 
                                                                                                                           (competitor.car)
                                                                                                                           (competitor.classEntered)  
                                                                                                                           (competitor.category) 
                                                                                                                           (stageTimes)
                                                                                                                           (superRally competitor)
            let command = new NpgsqlCommand(insertString, connection)
            let dataReader = command.ExecuteNonQuery()
            //log Level.Info (competitor.carNumber.Replace("R",""))      
            ()

        let update() =
            let x = parseCarNumber competitor
            competitor.carNumber <- x
            competitor.category <- classDict.[competitor.classEntered.Trim()]
            let updateString = sprintf "UPDATE \"Entrant\" SET \"StageData\" = '%s', \"SuperRally\" = '%b' WHERE \"Id\" = %i AND \"Number\" = %i" (stageTimes)
                                                                                                                            (superRally competitor)
                                                                                                                            (eventId)
                                                                                                                            (Convert.ToInt32(competitor.carNumber.Replace("R","").Trim())) 
            let command = new NpgsqlCommand(updateString, connection)
            let dataReader = command.ExecuteNonQuery()    
            ()
          
        let selectQuery =  
            let x = parseCarNumber competitor
            competitor.carNumber <- x
            competitor.category <- classDict.[competitor.classEntered.Trim()]
            sprintf "SELECT COUNT(*) FROM \"Entrant\" WHERE \"Id\" = %i AND \"Number\" = %i" (eventId)
                                                                                              (Convert.ToInt32(competitor.carNumber.Replace("R","").Trim())) 
        let command = new NpgsqlCommand(selectQuery, connection)
        let dataReader = command.ExecuteScalar().ToString()

        match dataReader with
        | "1" -> update()
        | _ -> insert()


module stuff =
    open FSharp.Data
    open System   
    open Types

    let getId(isNew, event) = 
        let StageToSeconds(str:string) = 
            let min = str.Substring(0,str.LastIndexOf(":"))
            let sec = str.Substring(str.LastIndexOf(":") + 1,4)
            let total = (60.0 * Convert.ToDouble(min) + Convert.ToDouble(sec))
            total


        let PenaltyToSeconds(str:string) = 
            let min = str.Substring(0,str.LastIndexOf(":"))
            let sec = str.Substring(str.LastIndexOf(":") + 1,2)
            let total = (60.0 * Convert.ToDouble(min) + Convert.ToDouble(sec))
            total


        let Starters =
            let results = HtmlDocument.Load("http://results.shannonsportsit.ie/entries.php?rally=" + event)
            let body = results.Descendants ["a"] 
            body
            |> Seq.filter (fun x -> x.ToString().Contains("entrant"))
            |> Seq.filter (fun x -> x.InnerText().Contains("Back to Index") |> not)
            |> Seq.choose (fun x -> 
                    x.TryGetAttribute("href")
                    |> Option.map (fun a -> a.Value())
                    |> Option.map(fun x -> x.Substring(x.LastIndexOf("=")+1, x.Length - (x.LastIndexOf("=")+1)))
            )
        

        let EntrantInformation = Starters |> Seq.map(fun index ->
                let results = HtmlDocument.Load("http://results.shannonsportsit.ie/competitor.php?rally=" + event + "&entrant=" + index.ToString())
                let body = results.Descendants["td"]
                let DriverInformation = 
                    body 
                    |> Seq.map(fun x -> x.InnerText())
                    |> Seq.filter (fun (x) -> x <> "Driver" &&
                                                x <> "Codriver" &&
                                                x <> "Car Number" &&
                                                x <> "Make" &&
                                                x <> "Address" &&
                                                x <> "Class")
                    |> Seq.take 6

                let StageInformation = 
                    body 
                    |> Seq.skip 13
                    |> Seq.mapi(fun i x -> i, x.InnerText())
                    |> Seq.filter (fun (x,_) -> x % 6 = 0)
                    |> Seq.takeWhile (fun (_,y) -> y <> "")
                    |> Seq.map(fun (x,y) -> y |> StageToSeconds)

                let Penalty = 
                    body 
                    |> Seq.skip 15
                    |> Seq.mapi(fun i x -> i, x.InnerText())
                    |> Seq.filter (fun (x,_) -> x % 6 = 0)
                    |> Seq.takeWhile (fun (_,y) -> y <> "")
                    |> Seq.map(fun (x,y) -> y |> PenaltyToSeconds)

                let PenaltyInformation = 
                    Penalty |> Seq.mapi(fun stage stagePenaltyTime -> 
                        match stage with
                        | 0 -> stagePenaltyTime
                        | _ -> 
                            match (Penalty |> Seq.nth (stage - 1)) = stagePenaltyTime with
                            | true -> 0.0
                            | false -> stagePenaltyTime
                    )
                DriverInformation, StageInformation, PenaltyInformation 
        )

        let CompetitorEventInformation = 
            EntrantInformation |> Seq.map(fun (driverInformation:seq<string>, y:seq<float>, z:seq<float>) ->
                try
                    let stageAndPenaltyTimes = Seq.map2(fun (y:float) (penalty:float) -> (y), (penalty)) <| y <| z
                    let info = {carNumber = driverInformation |> Seq.nth 0;
                                driver =  driverInformation |> Seq.nth 1;
                                codriver = driverInformation |> Seq.nth 2;
                                address = driverInformation |> Seq.nth 3;
                                car = driverInformation |> Seq.nth 4;
                                classEntered = driverInformation |> Seq.nth 5;
                                category = "";
                                stageData = stageAndPenaltyTimes }
                    info        
                with
                    | :? System.InvalidOperationException as ex -> 
                    let info = {carNumber = driverInformation |> Seq.nth 0;
                                driver =  driverInformation |> Seq.nth 1;
                                codriver = driverInformation |> Seq.nth 2;
                                address = driverInformation |> Seq.nth 3;
                                car = driverInformation |> Seq.nth 4;
                                classEntered = driverInformation |> Seq.nth 5;
                                category = "";
                                stageData = Seq.empty }
                    info
                )

        let Connection = new Npgsql.NpgsqlConnection(Database.connectionString)
        Connection.Open()
//        log Level.Info "Opening db connection"
        let eventId =
            match isNew with
            | "true" | "True" -> Database.GetId Connection
            | _ -> Database.GetId Connection - 1

        let getCategories = 
            let classDictonary = Database.GetCatogeries Connection eventId
            classDictonary
        
        CompetitorEventInformation |> Seq.iter(fun eventInformation -> Database.testDB(eventInformation, Connection, eventId, getCategories))
        //CompetitorEventInformation |> Seq.iter(fun eventInformation -> printfn "%A" eventInformation)
        Connection.Close()
//        log Level.Info "Closed db connection"
//        Logger.log Level.Debug "Finished Replay"
//        Logger.log Level.Debug "Finished Replay"
        "Done"

