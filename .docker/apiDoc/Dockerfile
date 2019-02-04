FROM node:6-alpine

RUN yarn global add apidoc

RUN rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY ./.docker/apiDoc/conf/ /usr/src

WORKDIR /usr/src

CMD [ "node" ]