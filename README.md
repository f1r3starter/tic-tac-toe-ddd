#TIC-TAC-TOE in DDD style

Projects backend is located in './src' path, frontend in './front' path
To run project, you need to have docker and docker-compose installed on your working station.

`cd devops && docker-compose up`

After that you can find game running on the http://localhost:8008 address.

Backend contain 4 paths:
- Presentation is responsible for interaction with client
- Application is responsible for interaction with infrastructure and domain
- Infrastructure contains all infrastructure dependencies, for now we save game state into session, but with this code architecture it can be easily be substituted with smth like Redis
- Domain contains core domain logic of the application

Frontend is using react+redux, logic is implemented via redux sagas

TBD: 
- write more tests
- use symfony validators for incoming data

Have fun!
