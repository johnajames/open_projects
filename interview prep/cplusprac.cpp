

// these are a set of practice exercises to reacquaint myself with c++ and oop 
// techniques

// #include <iostream>
// using namespace std;

// int main(int argc, char const *argv[])
// {
// 	// remember you have to declare your data types
// 	int numberoflanguages;
// 	/* code */

// 	// c++ syntax for console i/o is a bit different from c and java
// 	// remember
// 	cout <<  "Hello to me\n"
// 			<< "This is a second line.\n";

// 	cout << "this is one of many programming languages I kknow\n"
// 			<< "how programming languages do you speak?";

// 	cin >> numberoflanguages;

// 	if (numberoflanguages < 1)
// 			cout << "need more than that";
// 	else
// 			cout << "lets do this";


// 	return 0;
// }



/////////////// Hash Tables
// Data Structure that maps keys to values for efficient lookup

// Fundamental Structure - has an underlying array and a hash function
// When you want to insert an object and it's key, the hash function maps the key to an integer
// which indicates the index in the array, then the object is stored at that index

// in order to prevent creating a very large array can create a linked list at each 
// array insertion point  

// collision occurs when two keys are maped to the same map index
// this can be aleviated by allowing each bucket to to store multiple records
// for a hash table you have to store the data types
#include <iostream>
#include <cstdlib>
#include <string>
#include <array>


using namespace std;

const int arrcap = 1000;

int main(int argc, char const *argv[])
{
	// dynamic array
	int *dynarray;

	// new keyword 
	dynarray = new int[arrcap];

	dynarray[0] = 5;
	dynarray[1] = 7;
	dynarray[2] = 9;
	dynarray[4] = 0;
	dynarray[8] = 12;
	dynarray[9] = 13;
	dynarray[10] = 14;
	dynarray[30] = 15;
	dynarray[40] = 16;
	dynarray[50] = 78;
	dynarray[50] = 90;


	cout << "Array\n";

	for (int i = 0; i < sizeof(dynarray) ; ++i)
	{
		/* code */
		cout << dynarray[i] << endl;

	}
	delete []dynarray;

	cout << dynarray[0];


	return 0;
}

