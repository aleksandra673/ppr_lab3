#!/usr/bin/env python
from SimpleXMLRPCServer import SimpleXMLRPCServer
import sys
import logging

address = ('127.0.0.1', 9001)
server = SimpleXMLRPCServer(address, logRequests=0) 

class Server2:
    def processData(self, msg):
        return msg[::-1]

if __name__ == '__main__':
    try:
        server.register_instance(Server2())
        server.serve_forever()
    except KeyboardInterrupt:
        server.server_close()