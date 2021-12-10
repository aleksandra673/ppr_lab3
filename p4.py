#!/usr/bin/env python
from SimpleXMLRPCServer import SimpleXMLRPCServer
import sys
import logging


address = ('127.0.0.1', 9002)
server = SimpleXMLRPCServer(address, logRequests=0) 

class Server3:
    
    def processData(self, msg):
        
        return msg.upper()

if __name__ == '__main__':
    try:
        
        server.register_instance(Server3())
        
        server.serve_forever()
    except KeyboardInterrupt:
        server.server_close()