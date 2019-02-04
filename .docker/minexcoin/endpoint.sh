#!/usr/bin/env bash
chmod +x /root/minexcoind
chmod +x /root/minexcoin-cli
/root/minexcoind -txindex=1 -rpcthreads=${MINEXNODE_RPCTHREADS} -conf="/root/.Minexcoin/Minexcoin.conf"
