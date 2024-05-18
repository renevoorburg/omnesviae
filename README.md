# OmnesViae

OmnesViae is a route planner for the Roman Empire, based on historical data. Its main source is a (medieval copy of) a Roman map, known as the Tabula Peutingeriana (TP), showing the cursus publicus, the road network of the Roman Empire. Since the western most part of the map has been lost, places and routes in that part of the empire are from the Antonine Itinerary (Itinerarium Antonini).
The shortest route is calculated using the distances mentioned in these antique sources.

Besides a route planner, OmnesViae lets you study a high resolution copy of the tabula peutingerina.

## Running OmnesViae

OmnesViae is online at [omnesviae.org](https://omnesviae.org).

### Your local copy of OmnesViae

You can run OmnesViae on your local computer using `docker` ([get Docker](https://docs.docker.com/get-docker/)). First, clone this repository using git, by executing this command in your terminal or command prompt (or use the download button):

    git clone http://github.com/renevoorburg/omnesviae.git

Now you can build the image and start the containers required. This is done by executing these commands, while in the project directory:

	docker-compose build
	docker-compose up -d

Two containers are started. The OmnesViae PHP application will be available at [http://localhost:8080/](http://localhost:8080/) . It uses the *iipsrv* iiif image server, running at port `8081`. The base URI of the high resolution image of the tabula peutingeriana is [http://localhost:8081/iiif/peutinger.jp2/info.json](http://localhost:8081/iiif/peutinger.jp2/info.json).

### Adding your interpretation of the road map

The data source for the route planner and the displayed road network is the JSON-LD file `data/omnesviae.json`. You can edit it, to match your interpretation of the tabula peuterina, and then load by pointing the `?datasource` parameter to it. For example, use `https://omnesviae.org/?datasource=https://omnesviae.org/data/omnesviae.json`, to explicitly point it to the default definition.

## Credits

OmnesViae.org was developed by René Voorburg. Most data behind OmnesViae is based on Richard Talbert's scholarly work on the tabula peuringerina, *Rome's World: The Peutinger Map Reconsidered*. 

If you like OmnesViae, consider [buying me a coffee](https://buymeacoffee.com/omnesviae). Much appreciated!

