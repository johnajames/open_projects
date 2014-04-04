// John James
// jamesjoh@onid.oregonstate.edu
// cs311-400
// Homework 6
   
// Prints twin primes from 2 to a user defined number utilizing multiple threads and a bit array.

#define _POSIX_SOURCE

#include <stdio.h>
#include <stdlib.h>
#include <limits.h>
#include <math.h>
#include <unistd.h>
#include <errno.h>
#include <pthread.h>
#include <getopt.h>
#include <sys/time.h>

#define BITSIZE 32
#define setBit(a, k) 	( a[(k / BITSIZE)] |= (1 << (k % BITSIZE)) )
#define clearBit(a, k)	( a[(k / BITSIZE)] &= ~(1 << (k % BITSIZE)) )
#define testBit(a, k)	( a[(k / BITSIZE)] & (1 << (k % BITSIZE)) )



void *soe( void* );
void printprimes( void );
void prepbits( void );
void createThreads( void );
void joinThreads( void );
void prepthreads( void );
void clearall( void );
unsigned int countTwins( void );
void showuse( void );
void writetime( struct timeval, struct timeval );



static unsigned int *bits;				
static unsigned int maxNum = UINT_MAX;	
static int numThreads = 1;				
static int quiet = 0;					
static int debug = 0;					
static int verbose = 0;					

pthread_mutex_t mutexBit;				
pthread_t *threads;						
pthread_attr_t attr;				

int main(int argc, char **argv)
{
	unsigned int twins = 0; 			
	int args;							
	struct timeval startTime, endTime;	
	srand(time(NULL));

	while ( (args = getopt(argc, argv, "m:c:qdv")) != - 1)
	{
		switch(args)
		{
			case 'm':
				maxNum = atoi(optarg);
				break;
			case 'c':
				numThreads = atoi(optarg);
				break;
			case 'q':
				quiet = 1;
				break;
			case 'd':
				debug = 1;
				break;
			case 'v':
				verbose = 1;
				break;
			default:
				showuse();
				exit(EXIT_FAILURE);
		}
	}

	
	if (maxNum == -1)
		maxNum = UINT_MAX; 
	if (numThreads == -1)
		numThreads = 1;

	if (debug)
		printf("m: %u - c: %d\n", maxNum, numThreads);

	
	if ( numThreads > 20)
		showuse();

	
	if (debug)
		printf("Preparing bit array\n");
	prepbits();
	if (debug)
		printf("Preparing threads\n");
	prepthreads();

	// start time
	gettimeofday(&startTime, NULL);
	if (debug)
		printf("Creating threads\n");
	createThreads();
	if (debug)
		printf("Joining threads\n");
	joinThreads();
	/* prints all primes, not just twins */
	if (debug)
		printprimes();
	if (debug)
		printf("Counting twins\n");
	twins = countTwins();
	gettimeofday(&endTime, NULL);
	
	// end time
	writetime(startTime, endTime);

	// used for tests
	if (debug)
		printf("Threads: %d - Max: %u - Twins: %u\n", numThreads, maxNum, twins);
	/* shut it all down */
	clearall();

	return 0;
}


void *soe( void *arg )
{
	unsigned int numTest; 											
	long index = (long)arg;											
	unsigned int start = (index * (maxNum + 1)) / numThreads; 		
	unsigned int end = ((index + 1) * (maxNum + 1)) / numThreads; 	

	if (debug)
	{
		printf("Thread %ld working\n", index);						
		printf("start: %u - end: %u\n",start, end);
	}
	/* Determine if number is prime */
	pthread_mutex_lock(&mutexBit);
	for (unsigned int i = start; i <= end; i++)
	{
		numTest = (i);
		if (testBit(bits, numTest))
		{
			//pthread_mutex_lock(&mutexBit);
			/* loop through rest of array and determine if the number is a divisor */
			for (int k = numTest; (k * numTest) < maxNum; k++)
			{
				clearBit(bits, k * numTest); // not a prime
			}
			//pthread_mutex_unlock(&mutexBit);
		}
	}
	pthread_mutex_unlock(&mutexBit);
	
	pthread_exit(NULL);

	return NULL;
}

unsigned int countTwins( void )
{
	unsigned int twins = 0;		// number of twins in bit array bits
	//unsigned int numTest;		// specific number to test it's previous neighbor
	int column = 0; 			// 9 columns to match test file

	for (unsigned int i = 0; i < (maxNum - 2); i++)
	{
		if ( testBit(bits, i) && testBit(bits, (i + 2)) )
		{
			twins++;
			if (!quiet && !verbose)
				printf("%u %u\n", i, (i + 2));
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


void printprimes( void )
{
	unsigned int numTest; // number to test

	for (unsigned int i = 0; i < (maxNum /  BITSIZE); i++)
	{
		for (int j = 0; j < BITSIZE; j++)
		{
			numTest = ((i * BITSIZE) + j);

			if (testBit(bits , numTest)) // found a prime, print it
			{
				printf("%d\n",numTest );
			}
		}
	}

	return;
}


void prepbits( void )
{
	bits = malloc(sizeof(unsigned int) * (maxNum / BITSIZE) + 1);

	for (unsigned int i = 0; i < (maxNum / BITSIZE); i++)
	{
		for (int j = 0; j < BITSIZE; j++)
			setBit(bits, ((i*BITSIZE) + j));
	}
	clearBit(bits, 0);
	clearBit(bits, 1);
}


void prepthreads( void )
{
	pthread_mutex_init(&mutexBit, NULL);
	pthread_attr_init(&attr);
	pthread_attr_setdetachstate(&attr, PTHREAD_CREATE_JOINABLE);
}


void createThreads( void )
{
	long count = 0; // index for assigning values to a thread

	threads = (pthread_t *)malloc(sizeof(pthread_t) * numThreads);

	for (int i = 0; i < numThreads; i++)
	{
		pthread_create(&threads[i], &attr, soe, (void *)count) < 0;
		count++;
	}
}


void joinThreads( void )
{
	for (int i = 0; i < numThreads; i++)
		pthread_join(threads[i], NULL);
}


void clearall( void )
{
	pthread_attr_destroy(&attr);
	pthread_mutex_destroy(&mutexBit);
	free(threads);
	free(bits);
}


void showuse( void )
{
	printf("./primePThread [arguments] -m <max number> -c <threads>\n");
	printf("Arguments:\n");
	printf("-d\t\tDebug options. Displays simple debugging information\n");
	printf("-v\t\tVerbose mode. Outputs the first twin, for comparison, should use quiet mode at same time\n");
	printf("-m\t\tMax number to test. Cannot be greater than UINT_MAX\n");
	printf("-c\t\tNumber of threads. Cannot exceed 20\n");
	printf("-q\t\tNo output to the screen. For timing purposes\n");

	exit(EXIT_FAILURE);
}


void writetime(struct timeval startTime, struct timeval endTime)
{
	FILE *fp;
	fp = fopen("threadTimes.csv", "ab+");

	int timeTaken = (int)(1000000 * ((double)(endTime.tv_usec - startTime.tv_usec) / 1000000 + (double)(endTime.tv_sec - startTime.tv_sec)));

	fprintf(fp, "%u,%d,%d\n", maxNum, numThreads, timeTaken);
	fclose(fp);

	return;
}

