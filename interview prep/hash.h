/*









*/

#include <cstdlib>
#include <iostream>
#include <string>

using namespace std;

indef HASH_H
#define HASH_H


class Hash{
	public:
		// function prototypes
		// the actual hash function takes a string 
		// variable to serve as a key
		// evaluates string to return an int
		// that will serve as index into hash table
		int hash(string key); 


};

#endif // Hash.h
