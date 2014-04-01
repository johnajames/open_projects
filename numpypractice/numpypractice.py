import numpy as np

# create an np array of zeros and define column types
recarr = np.zeros((2,), dtype=('i4,f4,a10'))
toadd = [(1,2.,'Hello'),(2,3,"World")]
recarr[:] = toadd

# Now creating the columns we want to put
# in the recarray
col1 = np.arange(2)+1
col2 = np.arange(2, dtype=np.float32)
col3 = ['Hello','World']

# Here we create a list of tuples that is
# identical to the previous toadd list.

todadd = zip(col1,col2,col3)

# assigning values to recarr
recarr[:] = toadd

# assigning names to each column, which are
# now by default called 'f0', 'f1', 'f2'
recarr.dtype.names = ('Integers', 'Floats', 'Strings')

# if we want to access one of the colmns by its name, we
# can do the following

recarr('Integers')
# array([1,2], dtype=int32)

