-- amulligan 01/12/2015

-- Killarney Historics Stage Rally 2015

-- Event_Individual
INSERT INTO "Event_Individual" VALUES (
  '3',
  '{
    "name" : "Killarney Historics Stage Rally 2015",
    "startdate" : "2015-12-04",
    "finishdate" : "2015-12-05",
    "surface" : "Tarmac",
    "image": "image.jpg",
    "service" : [1,4],
    "endofday" : [8],
    "category": [
        {
            "type": "Historic",
            "class": "B1"
        },
		{
            "type": "Historic",
            "class": "B2"
        },
		{
            "type": "Historic",
            "class": "B3"
        },
		{
            "type": "Historic",
            "class": "B4"
        },
		{
            "type": "Historic",
            "class": "B5"
        },
		{
            "type": "Historic",
            "class": "C1"
        },
		{
            "type": "Historic",
            "class": "C2"
        },
		{
            "type": "Historic",
            "class": "C3"
        },
		{
            "type": "Historic",
            "class": "C4"
        },
		{
            "type": "Historic",
            "class": "C5"
        },
		{
            "type": "Historic",
            "class": "D1"
        },
		{
            "type": "Historic",
            "class": "D2"
        },
		{
            "type": "Historic",
            "class": "D3"
        },
		{
            "type": "Historic",
            "class": "D4"
        },
		{
            "type": "Historic",
            "class": "D5"
        },
		{
            "type": "Historic",
            "class": "E1"
        },
		{
            "type": "Historic",
            "class": "E2"
        },
		{
            "type": "Historic",
            "class": "E3"
        },
		{
            "type": "Historic",
            "class": "E4"
        },	
        {
            "type": "Historic",
            "class": "K"
        },		
		{
            "type": "Modified",
            "class": "1"
        },
		{
            "type": "Modified",
            "class": "2"
        },
		{
            "type": "Modified",
            "class": "3"
        },
		{
            "type": "Modified",
            "class": "4"
        },
		{
            "type": "Modified",
            "class": "5"
        },
		{
            "type": "Modified",
            "class": "6"
        },
		{
            "type": "Modified",
            "class": "7"
        },
		{
            "type": "Junior",
            "class": "J1"
        },
		{
            "type": "Junior",
            "class": "J2"
        }
    ]
  }'
);


-- Event_Category
INSERT INTO "Event_Category" VALUES(3,'Modified',
		'{"(Mols Gap, 17.58,05 December 2015 08:45)", "(Coolick,14.57,05 December 2015 11:20)",
		  "(Stage 3,16.04,05 December 2015 11:54)", "(Stage 4,10.71,05 December 2015 12:36)",
		  "(Coolick,14.57,05 December 2015 14:48)", "(Stage 6,16.04,05 December 2015 15:22)", 
		  "(Stage 7,10.71,05 December 2015 17:00)"}',110.0, 0)

INSERT INTO "Event_Category" VALUES(3,'Historics',
		'{"(Mols Gap, 17.58,05 December 2015 08:45)", "(Coolick,14.57,05 December 2015 11:20)",
		  "(Stage 3,16.04,05 December 2015 11:54)", "(Stage 4,10.71,05 December 2015 12:36)",
		  "(Coolick,14.57,05 December 2015 14:48)", "(Stage 6,16.04,05 December 2015 15:22)", 
		  "(Stage 7,10.71,05 December 2015 17:00)"}',110.0, 0)

INSERT INTO "Event_Category" VALUES(3,'Juniors',
		'{"(Stage 4,10.71,05 December 2015 12:36)", "(Coolick,14.57,05 December 2015 14:48)",
		  "(Stage 6,16.04,05 December 2015 15:22)", "(Stage 7,10.71,05 December 2015 17:00)"}',50.0, 4)
