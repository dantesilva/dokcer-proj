FROM phpmyadmin/phpmyadmin
RUN apt-get update -yqq \
&& apt-get -yqq install git \
&& apt-get -yqq install wget \
&& apt-get install rsyslog -yqq \
&& apt-get clean