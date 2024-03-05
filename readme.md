# Docker Wordpress enironment

I am in the process of migrating a companies webite and wanted a development environment that I could spin up with an ssl as some plugins etc do not work without this. I have used docker before for a university project and this seemed like the perfect tool for the job. I found this [video](https://www.youtube.com/watch?v=kIqWxjDj4IU) incredibly useful. 

He mentions at around the 10 minute mark that he has edit the domain but doesn't spell out what you need to do.

I did:
'sudo nano /etc/hosts'

then edited it so that it looked like :
'127.0.0.1       localhost.test'

replace localhost.test with whatever you want the domain you would like to use.

I used mkcert and I found it to work quite well out of the box (Openssl available too)

## Next Steps

I am going to be looking here when configuring subdomains for nginx:
[Extra config for nginx](https://www.nginx.com/resources/wiki/start/topics/recipes/wordpress/)

I will likely update some of the image versions as well as the vid came out in 2021

