#!/usr/bin/env python
from SimpleXMLRPCServer import SimpleXMLRPCServer
import sys
import logging


address = ('127.0.0.1', 9999)
server = SimpleXMLRPCServer(address, logRequests=0) 

class Server1:
   
    def __init__(self):
        #zdefiniowana lista (slownik) uslug. 
        self.ports = dict({"9001": "Odwracanie", "9002": "Shiftowanie"})

    def getServicePorts(self, params):
        
        print self.ports
        
        return self.ports

if __name__ == '__main__':
    try:
        
        server.register_instance(Server1())
        
        server.serve_forever()
    except KeyboardInterrupt:
        server.server_close()