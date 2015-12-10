-- amulligan 10/11/2015

-- Kerry Mini Stages 2015

-- Event_Individual
INSERT INTO "Event_Individual" VALUES (
  '2',
  '{
    "name" : "Kerry Mini Stages 2015",
    "startdate" : "2015-10-07",
    "finishdate" : "2015-10-08",
    "surface" : "Tarmac",
    "image": "image.jpg",
    "service" : [2,4],
    "endofday" : [7],
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
            "type": "Historics,
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
INSERT INTO "Event_Category" VALUES(2,'Main Field',
		'{"(Ardagh,14.4,08 November 2015 10:24)", "(Ahamore,15.1,08 November 2015 11:02)",
		  "(Ardagh,14.4,08 November 2015 12:26)", "(Ahamore,15.1,08 November 2015 13:04)",
		  "(Ardagh,14.4,08 November 2015 14:28)", "(Ahamore,15.1,08 November 2015 15:06)"}',98.5, 0)

INSERT INTO "Event_Category" VALUES(2,'Juniors',
		'{"(Ardagh,14.4,08 November 2015 10:24)", "(Ahamore,15.1,08 November 2015 11:02)",
		  "(Ardagh,14.4,08 November 2015 12:26)", "(Ahamore,15.1,08 November 2015 13:04)",
		  "(Ardagh,14.4,08 November 2015 14:28)", "(Ahamore,15.1,08 November 2015 15:06)"}',98.5, 0)

INSERT INTO "Event_Category" VALUES(2,'Historics',
		'{"(Ardagh,14.4,08 November 2015 10:24)", "(Ahamore,15.1,08 November 2015 11:02)",
		  "(Ardagh,14.4,08 November 2015 12:26)", "(Ahamore,15.1,08 November 2015 13:04)",
		  "(Ardagh,14.4,08 November 2015 14:28)", "(Ahamore,15.1,08 November 2015 15:06)"}',98.5, 0)
