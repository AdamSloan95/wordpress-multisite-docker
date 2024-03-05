# Docker Wordpress Multisite Development Environment

I am in the process of migrating a companies webite and wanted a development environment that I could spin up with an ssl as some plugins etc do not work without this. I have used docker before for a university project and this seemed like the perfect tool for the job. I found this [video](https://www.youtube.com/watch?v=kIqWxjDj4IU) incredibly useful. 

## Setup

### Install Docker/Docker Compose
Get it [here](https://www.docker.com/products/docker-desktop/) - Docker compose is included with the desktop versions of Docker on Mac and Windows.

### Clone this repo
Clone this repo to you selected folder or download the zip and unzip. 

### Download Wordpress
Download the desired version of wordpress from [here](wordpress.org/download/)

### Install mkcert

mkcert helps us to create certificates so browsers will trust our wordpress sites in this project.
I wrote a quick script that uses brew to install mkcert `brew install mkcert` and create the a 'certs' directory and install ssl certificates for domains. Otherwise you can get it [here] (https://github.com/FiloSottile/mkcert)

You could also just create this "certs" directory in the root directory then run commands manually. As I am doing a subdomain multisite install I have used:

```
mkcert -install
```
Then
```
mkcert -cert-file ./certs/localhost.test.pem -key-file ./certs/localhost.test-key.pem localhost.test site1.localhost.test site2.localhost.test site3.localhost.test
```

Replace these domains with whatever you want, although wordpress does demand you have a hostname with a "." to use subdomain multisite. If you just wanted a simple wordpress install without multisite this could just look like :

```
mkcert -cert-file ./certs/localhost.pem -key-file ./certs/localhost-key.pem localhost
```

You will need to add the domain(s) in the next step. You will need to make sure that the ssl declarations at the bottom of the nginx conf files match what the certificates are named and that source folder in the Dockerfile.nginx is right is the right location. 

It's worth mentioning that OpenSSL is another option for achieving the same result.

### Add the domains to /etc/hosts

In the video I mentioned earlier at about 10 mins the person taking the tutorial mentions that he has changed the domain but doesn't go into detail. For me on mac it was:

```
sudo nano /etc/hosts
```

on windows this file is located at "C:\Windows\System32\drivers\etc\hosts"

And you can just list the site you want 127.0.0.1 to point to. For Example:

```
127.0.0.1       localhost.test site1.localhost.test site2.localhost.test site3.localhost.test
```

### Create Env Variables 
create a .env file in the root folder you are working in.

```
export MYSQL_DATABASE=wordpress
export MYSQL_USER=wordpress
export MYSQL_PASSWORD=pass
export MYSQL_ROOT_PASSWORD=pass
```

Then run :

```
source .env
```

To check that these have been captured you can just do :

```
env
```

These variables are used in the docker-compose.yml 

## Run 

```
Docker compose up -d
```

This will create all the containers built between the docker-compose.yml and Dockerfiles and deploy them in detached mode. 

If all is good you should be able to start the setup, it will ask you:

1. Database name 
2. Database username
3. Database password
4. Database host
5. Table prefix (if you want to run more than one WordPress in a single database)

most of these will be environment variables but the database host is actually the name of your service. In my case that was database. Table prefix should be fine as is. 

### Add Multisite Config

If you are just using localhost/ don't need multisite that should be you all setup. In my case I could then use wpcli and docker compose run to run commands in the cli container. 

```
wp core multisite install --title="Network Title" --admin_user=admin --admin_password=admin --admin_email=admin@example.com
```

then 

```
wp config set SUBDOMAIN_INSTALL true --raw
```

And that should be everything.

Run `docker compose down` to tear it down. 

Then any time you need to run it `docker compose up -d` from the same directory.


## Use

You can then add sites to the wordpress multisite from the dashboard. If you need more sites than you initially thought, you will need to add them to the etc/host file and regenerate certificates.

You may need to run 

```
docker compose up -d --build
```

To ensure the new certificates are added to the containers nginx config.
