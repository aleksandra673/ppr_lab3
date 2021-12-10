#!/usr/bin/env python
from SimpleXMLRPCServer import SimpleXMLRPCServer
import sys
import logging

address = ('127.0.0.1', 9001)
server = SimpleXMLRPCServer(address, logRequests=0) 

class Server2:
    def processData(self, params):
        rev_list = [each_string[::-1] for each_string in params]
        return rev_list

if __name__ == '__main__':
    try:
        server.register_instance(Server2())
        server.serve_forever()
    except KeyboardInterrupt:
        server.server_close()