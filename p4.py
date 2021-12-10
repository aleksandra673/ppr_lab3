#!/usr/bin/env python
from SimpleXMLRPCServer import SimpleXMLRPCServer
import sys
import logging

address = ('127.0.0.1', 9002)
server = SimpleXMLRPCServer(address, logRequests=0) 

class Server3:
    def processData(self, params):
        upper_list = [each_string.upper() for each_string in params]
        return upper_list

if __name__ == '__main__':
    try:
        server.register_instance(Server3())
        server.serve_forever()
    except KeyboardInterrupt:
        server.server_close()