
// java is completely oop so 
// it has a little extra syntax

// public class javaprac {
// 	public static void main(String[] args) {
// 		int i;
// 		for (i=0; i<10; i++){
// 			System.out.println("hello, world");
// 		}
// 	}

// }

// Data Structure that maps keys to values for efficient lookup

// Fundamental Structure - has an underlying array and a hash function
// When you want to insert an object and it's key, the hash function maps the key to an integer
// which indicates the index in the array, then the object is stored at that index

// in order to prevent creating a very large array can create a linked list at each 
// array insertion point  

// Simple Hash Table in java
public HasMap<integer, Student> buildMap(Student[] students) {
	HashMap<integer, Student> map = new HashMap<integer, Student>();
	for (Student s : students) map.put(s.getId(),s);
	return map;
}

// Dynamically Resizing and Array or list provides O(1) access
public Array<String> merge(String[] words, String[] more)
	ArrayList<String> sentence = new ArrayList<String>();
	for (String w : words) sentence.add(w);
	for (String w: more) sentence.add(w);
	return sentence;
}


// String Bufffer runs in O(x + 2x+ ...nx) time
public String joinWords(String[] words) {
	String sentence = "";
	for (String w: words){
		sentence = sentence+w;
	}
	return sentence;
}

// stringBuffer creates an array of allt he strings, copying them back
// to a string only when necessary
public String joinWords(String[] words) {
	StringBuffer sentence = new StringBuffer();
	for (String w: words){
		sentence.append(w);
	}
	return sentence.toString();
}


