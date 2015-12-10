namespace FsWeb.Controllers

open System.Web
open System.Web.Mvc
open System.Net.Http
open System.Web.Http
open Npgsql

type ValuesController() =
    inherit ApiController()

    // GET /api/values
    member x.Get (isNew:string) (event:string) =         
        let y = rally.stuff.getId(isNew, event)
        [| y; |] |> Array.toSeq

    // POST /api/values
    member x.Post (isNew:bool) (event:string) = [| isNew.ToString(); event |] |> Array.toSeq
    // PUT /api/values/5
    member x.Put (id:int) ([<FromBody>] value:string) = ()
    // DELETE /api/values/5
    member x.Delete (id:int) = ()