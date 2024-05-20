1. ```git clone https://github.com/DewFill/moysklad-orders.git``` - clone repo

2. ```docker-compose -f compose-dev.yml -p moysklad-orders up -d --build``` - development, easily change internal files without needing to rebuild the Docker image. Any modifications made to the files on the local machine are immediately reflected inside the container, facilitating a rapid development workflow.

3. ```docker-compose -f compose-prod.yml -p moysklad-orders up -d --build``` - production, copies files into the container at build time rather than mounting them from the host machine. This approach ensures that the production environment is more secure and self-contained, as it doesn't rely on external file systems for its operation.

4. ```docker-compose -p moysklad-orders down -v``` - stop and remove the container, volume and network 