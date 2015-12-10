-- amulligan 10/11/2015

-- Westlodge Fastnet Rally 2015

-- Event_Individual
INSERT INTO "Event_Individual" VALUES (
  '1',
  '{
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
            "class": "1"
        },
		{
            "type": "Main Field",
            "class": "2"
        },
		{
            "type": "Main Field",
            "class": "3"
        },
		{
            "type": "Main Field",
            "class": "4"
        },
		{
            "type": "Main Field",
            "class": "5"
        },
		{
            "type": "Main Field",
            "class": "6"
        },
		{
            "type": "Main Field",
            "class": "7"
        },
		{
            "type": "Main Field",
            "class": "8"
        },
		{
            "type": "Main Field",
            "class": "9"
        },
		{
            "type": "Main Field",
            "class": "10"
        },
		{
            "type": "Main Field",
            "class": "11F"
        },
		{
            "type": "Main Field",
            "class": "11R"
        },
        {
            "type": "Main Field",
            "class": "12"
        },
        {
            "type": "Main Field",
            "class": "13"
        },
        {
            "type": "Main Field",
            "class": "14"
        },
        {
            "type": "Main Field",
            "class": "15"
        },
        {
            "type": "Juniors",
            "class": "16"
        },
        {
            "type": "Main Field",
            "class": "17"
        },
        {
            "type": "Historics",
            "class": "18"
        },
        {
            "type": "Main Field",
            "class": "19"
        },
        {
            "type": "Main Field",
            "class": "20"
        }
    ]
  }'
);


-- Event_Category
INSERT INTO "Event_Category" VALUES(1,'Main Field',
		'{"(Stage 1,23.4,25 October 2015 08:19)", "(Stage 2,13.4,25 October 2015 09:19)",
		  "(Stage 3,23.4,25 October 2015 10:19)", "(Stage 4,13.4,25 October 2015 11:19)",
		  "(Stage 5,23.4,25 October 2015 12:19)", "(Stage 6,13.4,25 October 2015 13:19)",
		  "(Stage 7,23.4,25 October 2015 14:19)", "(Stage 8,13.4,25 October 2015 15:19)", "(Stage 9,13.4,25 October 2015 16:19)"}',85.0, 0)

INSERT INTO "Event_Category" VALUES(1,'Juniors',
		'{"(Stage 1,23.4,25 October 2015 08:19)", "(Stage 2,13.4,25 October 2015 09:19)",
		  "(Stage 3,23.4,25 October 2015 10:19)", "(Stage 4,13.4,25 October 2015 11:19)",
		  "(Stage 5,23.4,25 October 2015 12:19)", "(Stage 6,13.4,25 October 2015 13:19)"}',55.0, 0)

INSERT INTO "Event_Category" VALUES(1,'Historics',
		'{"(Stage 1,23.4,25 October 2015 08:19)", "(Stage 2,13.4,25 October 2015 09:19)",
		  "(Stage 3,23.4,25 October 2015 10:19)", "(Stage 4,13.4,25 October 2015 11:19)",
		  "(Stage 5,23.4,25 October 2015 12:19)"}',55.0, 0)
