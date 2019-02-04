FROM ubuntu:16.04
RUN apt update
RUN apt --yes install software-properties-common
RUN add-apt-repository ppa:bitcoin/bitcoin

RUN apt update
RUN apt --yes install build-essential libtool autotools-dev automake pkg-config libssl-dev libevent-dev

RUN apt --yes install bsdmainutils libboost-all-dev libdb4.8-dev libdb4.8++-dev libminiupnpc-dev libzmq3-dev

RUN apt --yes install libqt5gui5 libqt5core5a libqt5dbus5 qttools5-dev qttools5-dev-tools libprotobuf-dev protobuf-compiler

RUN apt --yes install autoconf libsodium-dev

#cli

ADD .docker/minexcoin/endpoint.sh /docker-entrypoint.sh
RUN chmod 755 /docker-entrypoint.sh
#ENTRYPOINT ["docker-entrypoint.sh"]
EXPOSE 17785

CMD ["/docker-entrypoint.sh"]