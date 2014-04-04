# // John James
# // jamesjoh@onid.oregonstate.edu
# // cs311-400
# // Homework 6
   

# compiler
CC = gcc

# compiler flags
CFLAGS = -g -Wall -std=c99
   
# build target executable
TARGET = primes

# libraries to link into executable
LIBS =  -lrt -lm -lpthread 

# define the C source files
SRCS = primeMProc.c primeMThread.c

# define the C object files 
OBJS = $(SRCS:.c=.o)


all: primeMProc primePThread

primeMProc: primeMProc.o
	@$(CC) $(CFLAGS) $^ -o $@ $(LIBS)

primePThread: primePThread.o
	@$(CC) $(CFLAGS) $^ -o $@ $(LIBS)

%.o: %.c
	@$(CC) $(CFLAGS) -c $^ 

.PHONY: clean
clean:
	@echo "Cleaning files"
	@rm *.o primeMProc primePThread
	@rm -f jamesjoh-assignment6.tar.gz
tar:
	tar -jcvf jamesjoh-assignment6.tar.bzip *.c makefile prime-list primeTest.bash