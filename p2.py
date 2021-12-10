#!/usr/bin/env python
from SimpleXMLRPCServer import SimpleXMLRPCServer
import sys
import logging

address = ('127.0.0.1', 9999)
server = SimpleXMLRPCServer(address, logRequests=0) 

class Server1:
    def __init__(self):
        self.ports = dict({"odwracanie": "9001", "shiftowanie": "9002"})

    def getServicePorts(self, serviceName):
        print self.ports.get(serviceName)
        return self.ports.get(serviceName)

if __name__ == '__main__':
    try:
        server.register_instance(Server1())
        server.serve_forever()
    except KeyboardInterrupt:
        server.server_close()