// John James
// jamesjoh@onid.oregonstate.edu
// cs311-400
// Homework 6
   
// Prints twin primes from 2 to a user defined number utilizing multiple processes and a bit array.


#define _BSD_SOURCE

#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <fcntl.h>
#include <limits.h>
#include <errno.h>
#include <getopt.h>
#include <time.h>
#include <sys/types.h>
#include <sys/stat.h>
#include <sys/mman.h>
#include <sys/wait.h>
#include <sys/time.h>


#define BITSIZE 32
#define setBit(a, k)	( a[k / BITSIZE] |= (1 << (k % BITSIZE)) )
#define clearBit(a, k)	( a[k / BITSIZE] &= ~(1 << (k % BITSIZE)) )
#define valueBit(a, k)	( a[k / BITSIZE] & (1 << (k % BITSIZE)) )


void *mount(char *, int);
void prepbits( void );
void soe( void *);
void showprimes( void );
unsigned int countTwins( void );
void childblock( void );
void destroyAll( char *, unsigned int, void *);
void showuse( void );
void showtime(struct timeval, struct timeval);


static unsigned int maxNum = UINT_MAX;	
static unsigned int *bits;				
static int numChild = 1;				
static int quiet = 0;					
static int debug = 0;					
static int verbose = 0;					

int main(int argc, char **argv)
{
	long index = 0;					
	pid_t pid;						
	pid_t parent, child;			
	char *path="/burrowsd-MProc";	
	int args;						
	struct timeval startTime, endTime;	
	srand(time(NULL));

	/* get commandline argumetns using getopt functionality */
	while( (args = getopt(argc, argv, "m:c:qdv")) != -1 )
	{
		switch(args)
		{
			case 'm':
				maxNum = atoi(optarg);
				break;
			case 'c':
				numChild = atoi(optarg);
				break;
			case 'd':
				debug = 1;
				break;
			case 'v':
				verbose = 1;
				break;
			case 'q':
				quiet = 1;
				break;
			default:
				showuse();
		}
	}

	
	if (maxNum == -1)
		maxNum = UINT_MAX;
	if (numChild == -1)
		numChild = 1;

	
	if (numChild > 30)
		showuse();

	if (debug)
		printf("m: %u | c: %d\n", maxNum, numChild);

	
	unsigned int arraySize = (int)( (maxNum / BITSIZE) + 1 );		
	unsigned int bitmapSize = arraySize * (sizeof(unsigned int));	
	int objectSize = bitmapSize + (sizeof(unsigned int));		

	
	void *addr = mount(path, objectSize);
	/* similar to malloc, assign bits to point to shared memory space */
	bits = (unsigned int *)addr;

	
	if (debug)
		parent = getppid();

	if (debug)
		printf("Preparing bit array\n");
	
	prepbits();

	
	gettimeofday(&startTime, NULL);


	for (int i = 0; i < numChild; i++)
	{
		if (debug)
			printf("Index - %ld\n", index);
		switch(pid = fork())
		{
			case -1:
				/* error */
				exit(EXIT_FAILURE);
				break;
			case 0:
				/* child case */
				parent = getppid();	// parent process id, used for debugging
				child = getpid();	// child process id, used for debugging
				if (debug)
				{
					printf("Parent - %d | Child - %d\n", parent, child);
					fflush(stdout); // was having issues displaying printfs, this fixed it, via stackoverflow
				}
				/* pass soe function based on the index the process is handling */
				soe((void *)index);
				/* unmap space */
				munmap(addr, objectSize);
				break;
			default:
				index++;
				break;
		}
	}
	
	if (debug)
		printf("Waiting on children\n");
	childblock();
	if (debug)
		showprimes();
	if (debug)
		printf("Printing twins\n");
	
	countTwins();

	
	gettimeofday(&endTime, NULL);

	if (debug)
		printf("Deleting shared memory...\n");

	// Dealloc 
	destroyAll(path, objectSize, addr);

	showtime(startTime, endTime);

	return 0;
}


void *mount(char *path, int objectSize)
{
	int shmem_fd;	// shared memory file descriptor
	void *addr;		// address for mapped memory object

	shmem_fd = shm_open(path, O_CREAT | O_RDWR, S_IRUSR | S_IWUSR);
	ftruncate(shmem_fd, objectSize);
	addr = mmap(NULL, objectSize, PROT_READ | PROT_WRITE, MAP_SHARED, shmem_fd, 0);

	return addr;
}

void prepbits( void )
{
	for (unsigned int i = 0; i < maxNum; i++)
		setBit(bits, i); // initialize all bits to 1

	/* sets 0 and 1 to NOT prime */
	clearBit(bits, 0);
	clearBit(bits, 1);
}


void soe(void *arg)
{
	long index = (long)arg;
	unsigned int numTest;
	unsigned int start = (index * (maxNum + 1)) / numChild;
	unsigned int end = ((index + 1) * (maxNum + 1)) / numChild;

	if (debug)
		printf("Start - %d | End - %d\n", start, end);
	for (unsigned int i = start; i < end; i++)
	{
		numTest = i;
		if (debug)
			printf("Testing: %d\n", numTest);
		if (valueBit(bits, numTest))
		{
			for (int k = numTest; (k * numTest) < maxNum; k++)
				clearBit(bits, k * numTest);
		}
	}

	return;
}

void showprimes( void )
{
	for (unsigned int i = 0; i < (maxNum - 2); i++)
	{
		if (valueBit(bits, i))
			printf("%d\n", i);
	}
}


unsigned int countTwins( void )
{
	//unsigned int numTest;
	unsigned int twins = 0;
	int column = 0;

	for (unsigned int i = 0; i < (maxNum - 2); i++)
	{
		if ( (valueBit(bits, i)) && (valueBit(bits, (i + 2))) )
		{
			twins++;
			if (!quiet && !verbose)
			{
				printf("%u %u\n", (i), (i+2));
				fflush(stdout);
			}
			if (verbose) // output in neat, aligned columns
			{
				printf("%8u", i);
				column++;
				if (column == 9)
				{
					printf(" \n");
					column = 0;
				}
			}
		}
	}
	if (verbose)
		printf("\n");
	return twins;
}

void childblock( void )
{
	for (int i = 0; i < numChild; i++)
		wait(NULL);

	return;
}

void destroyAll( char *path, unsigned int objectSize, void *addr)
{
	munmap(addr, objectSize);	// unmaps shared memory region
	shm_unlink(path);			// deletes shared memory region
}

void showuse( void )
{
	printf("./primeMProc [arguments] -m <max number> -c <threads>\n");
	printf("Arguments:\n");
	printf("-d\t\tDebug options. Displays simple debugging information\n");
	printf("-v\t\tVerbose mode. Outputs the first twin, for comparison, should use quiet mode at same time\n");
	printf("-m\t\tMax number to test. Cannot be greater than UINT_MAX\n");
	printf("-c\t\tNumber of processes. Cannot exceed 30\n");
	printf("-q\t\tNo output to the screen. For timing purposes\n");

	exit(EXIT_FAILURE);
}

void showtime(struct timeval startTime, struct timeval endTime)
{
	FILE *fp;
	fp = fopen("procTimes.csv", "ab+");

	int timeTaken = (int)(1000000 * ((double)(endTime.tv_usec - startTime.tv_usec) / 1000000 + (double)(endTime.tv_sec - startTime.tv_sec)));

	fprintf(fp, "%u,%d,%d\n", maxNum, numChild, timeTaken);
	fclose(fp);

	return;
}