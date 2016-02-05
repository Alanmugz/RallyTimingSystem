-- amulligan 04/02/2016

-- Galway International Rally 2016

-- Event_Individual
INSERT INTO "Event_Individual" VALUES (
  '4',
  '{
    "name" : "Galway International Rally 2016",
    "startdate" : "2016-02-06",
    "finishdate" : "2016-02-07",
    "surface" : "Tarmac",
    "image": "image.jpg",
    "service" : [3,6,11,13],
    "endofday" : [9],
    "category": [
        {
            "type": "International",
            "class": "1"
        },
		{
            "type": "International",
            "class": "2"
        },
		{
            "type": "International",
            "class": "3"
        },
		{
            "type": "International",
            "class": "4"
        },
		{
            "type": "International",
            "class": "5"
        },
		{
            "type": "International",
            "class": "6"
        },
		{
            "type": "International",
            "class": "7"
        },
		{
            "type": "National",
            "class": "9"
        },
		{
            "type": "National",
            "class": "10"
        },
		{
            "type": "National",
            "class": "11F"
        },
		{
            "type": "National",
            "class": "11R"
        },
		{
            "type": "National",
            "class": "12"
        },
		{
            "type": "National",
            "class": "13"
        },
		{
            "type": "National",
            "class": "14"
        },
		{
            "type": "National",
            "class": "15"
        },
		{
            "type": "National",
            "class": "17"
        },
		{
            "type": "National",
            "class": "20"
        },
		{
            "type": "Historics",
            "class": "B1"
        },
		{
            "type": "Historics",
            "class": "B2"
        },	
        {
            "type": "Historics",
            "class": "B3"
        },		
		{
            "type": "Historics",
            "class": "B4"
        },
		{
            "type": "Historics",
            "class": "B5"
        },
		{
            "type": "Historics",
            "class": "C1"
        },
		{
            "type": "Historics",
            "class": "C2"
        },
		{
            "type": "Historics",
            "class": "C3"
        },
		{
            "type": "Historics",
            "class": "C4"
        },
		{
            "type": "Historics",
            "class": "C5"
        },
				{
            "type": "Historics",
            "class": "D1"
        },
		{
            "type": "Historics",
            "class": "D2"
        },	
        {
            "type": "Historics",
            "class": "D3"
        },		
		{
            "type": "Historics",
            "class": "D4"
        },
		{
            "type": "Historics",
            "class": "D5"
        },
		{
            "type": "Historics",
            "class": "E1"
        },
		{
            "type": "Historics",
            "class": "E2"
        },
		{
            "type": "Historics",
            "class": "E3"
        },
		{
            "type": "Historics",
            "class": "E4"
        },
		{
            "type": "Historics",
            "class": "K"
        },
		{
            "type": "Juniors",
            "class": "J1"
        },
		{
            "type": "Juniors",
            "class": "J2"
        }
    ]
  }'
);


-- Event_Category
INSERT INTO "Event_Category" VALUES(4,'International',
		'{"(Corbally Beg, 17.10, 06 February 2016 09:16)", "(Eyrecourt, 11.10,06 February 2016 09:56)","(Fairfield, 5.70, 06 February 2016 10:22)",
		  "(Corbally Beg, 17.10, 06 February 2016 11:47)", "(Eyrecourt, 11.10,06 February 2016 12:27)","(Fairfield, 5.70, 06 February 2016 12:53)",
		  "(Corbally Beg, 17.10, 06 February 2016 14:20)", "(Eyrecourt, 11.10,06 February 2016 15:00)","(Fairfield, 5.70, 06 February 2016 15:26)",
		  "(Stage 10, 19.60, 07 February 2016 08:57)", "(Stage 11, 10.00, 07 February 2016 09:44)","(Stage 12, 19.60, 07 February 2016 11:16)",
          "(Stage 13, 10.00, 07 February 2016 12:03)", "(Stage 14, 19.60, 07 February 2016 13:35)","(Stage 15, 10.00, 07 February 2016 14:22)"}'
		  ,190.4, 0)
		  
INSERT INTO "Event_Category" VALUES(4,'National',
		'{"(Corbally Beg, 17.10, 06 February 2016 09:16)", "(Eyrecourt, 11.10, 06 February 2016 09:56)","(Fairfield, 5.70, 06 February 2016 10:22)",
		  "(Corbally Beg, 17.10, 06 February 2016 11:47)", "(Eyrecourt, 11.10, 06 February 2016 12:27)","(Fairfield, 5.70, 06 February 2016 12:53)",
		  "(Corbally Beg, 17.10, 06 February 2016 14:20)", "(Eyrecourt, 11.10, 06 February 2016 15:00)","(Fairfield, 5.70, 06 February 2016 15:26)",
		  "(Stage 10, 19.60, 07 February 2016 08:57)", "(Stage 11, 10.00, 07 February 2016 09:44)","(Stage 12, 19.60, 07 February 2016 11:16)",
          "(Stage 13, 10.00, 07 February 2016 12:03)", "(Stage 14, 19.60, 07 February 2016 13:35)","(Stage 15, 10.00, 07 February 2016 14:22)"}'
		  ,190.4, 0)

INSERT INTO "Event_Category" VALUES(4,'Historics',
		'{"(Corbally Beg, 17.10, 06 February 2016 09:16)", "(Eyrecourt, 11.10, 06 February 2016 09:56)","(Fairfield, 5.70, 06 February 2016 10:22)",
		  "(Corbally Beg, 17.10, 06 February 2016 11:47)", "(Eyrecourt, 11.10, 06 February 2016 12:27)","(Fairfield, 5.70, 06 February 2016 12:53)",
		  "(Corbally Beg, 17.10, 06 February 2016 14:20)", "(Eyrecourt, 11.10, 06 February 2016 15:00)","(Fairfield, 5.70, 06 February 2016 15:26)",
		  "(Stage 10, 19.60, 07 February 2016 08:57)", "(Stage 11, 10.00, 07 February 2016 09:44)","(Stage 12, 19.60, 07 February 2016 11:16)",
                  "(Stage 13, 10.00, 07 February 2016 12:03)", "(Stage 14, 19.60, 07 February 2016 13:35)","(Stage 15, 10.00, 07 February 2016 14:22)"}'
		  ,190.4, 0)

INSERT INTO "Event_Category" VALUES(4,'Juniors',
		'{"(Stage 10, 19.60, 07 February 2016 08:57)", "(Stage 11, 10.00, 07 February 2016 09:44)","(Stage 12, 19.60, 07 February 2016 11:16)",
                  "(Stage 13, 10.00, 07 February 2016 12:03)", "(Stage 14, 19.60, 07 February 2016 13:35)","(Stage 15, 10.00, 07 February 2016 14:22)"}'
		  ,88.8, 9)
