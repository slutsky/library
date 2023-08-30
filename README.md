# Library

The application require docker.

If your `id -u` and `id -g` not equal `1000` you must define `DEFAULT_UID` and
`DEFAULT_GID` variables with:

```bash
export DEFAULT_UID=$(id -u)
export DEFAULT_GID=$(id -g)
```

If you also run container you must rebuild and restart containers:

```bash
docker-compose build
docker-compose down
docker-compose up -d
```

If you want to change WEB server port you must define `NGINX_PORT` variable.

For example:

```bash
export NGINX_PORT=8000
```

When you reopen terminal you must define environment variables again.

For start application:

```bash
docker-compose up -d
docker-compose exec php composer install
docker-compose exec php bin/console doctrine:migrations:migrate
```

If you want fill database with fixtures:

```bash
docker-compose exec php bin/console doctrine:fixtures:load --append
```

You can see API documentation on `/api/doc` URL. If you run application on the local machine: http://localhost/api/doc.
