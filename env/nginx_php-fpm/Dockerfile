FROM ubuntu:20.04
RUN apt-get update
RUN apt-get -y install python3 python3-nacl python3-pip python3-apt libffi-dev
RUN pip3 install ansible
COPY ansible /ansible
RUN ansible-playbook --connection=local --inventory 127.0.0.1, /ansible/install.yml

COPY nginx/nginx.conf /etc/nginx/nginx.conf
COPY fpm/www.conf /etc/php/7.4/fpm/pool.d/www.conf
