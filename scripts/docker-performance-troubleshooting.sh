#!/usr/bin/env bash

docker rm -f $(docker ps --filter label=io.lando.container=TRUE --all -q)

docker system prune -a