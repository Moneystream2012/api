#!/usr/bin/env bash
mongo admin -u ${MONGO_INITDB_ROOT_USERNAME} -p ${MONGO_INITDB_ROOT_PASSWORD} <<EOF
use testDb;
db.createUser({ user: "testUser", pwd: "testPass", roles: [ { role: "readWrite", db: "testDb" } ] });
EOF
#echo '' | mongo admin -u ${MONGO_INITDB_ROOT_USERNAME} -p ${MONGO_INITDB_ROOT_PASSWORD}