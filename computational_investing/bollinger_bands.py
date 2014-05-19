import csv
import pandas as pd
import datetime as dt
import numpy as np
import QSTK.qstkutil.qsdateutil as du
import QSTK.qstkutil.DataAccess as da
from collections import defaultdict
import QSTK.qstkutil.tsutil as tsu



def get_quote_df(timestamp_array, symbol_list):
    dataobj = da.DataAccess('Yahoo')

    ls_keys = ['close']
    ldf_data = dataobj.get_data(timestamp_array, symbol_list, ls_keys)

    d_data = dict(zip(ls_keys, ldf_data))

    for s_key in ls_keys:
        d_data[s_key] = d_data[s_key].fillna(method='ffill')
        d_data[s_key] = d_data[s_key].fillna(method='bfill')
        d_data[s_key] = d_data[s_key].fillna(1.0)

    return d_data['close']

def get_holdings_array(ldt_timestamps, ls_symbols):
    df_single = pd.DataFrame(index=ldt_timestamps, columns=ls_symbols)
    df_single = df_single.fillna(0.0)
    return df_single
    
def get_cumulative_value_df(ldt_timestamps):
    df_single = pd.DataFrame(index=ldt_timestamps, columns=['close'])
    df_single = df_single.fillna(0.0)
    return df_single

def get_timestamp_array(dt_start, dt_end):
    ldt_timestamps = du.getNYSEdays(dt_start, dt_end, dt.timedelta(hours=16))
    return ldt_timestamps

def read_command_line():
    vals = [20, 'MSFT']
    return vals


def write_time_series(filename, cum_val_df):
    with open(filename,'wb') as myfile:
        writer = csv.writer(myfile, delimiter=',')
        for row_index in cum_val_df.index:
            writer.writerow([row_index, cum_val_df.ix[row_index]])
            myfile.flush()
    
def normalize_df(input_df):
    ##print "Input DF", input_df
    values = input_df['close'].values
    ##print "Values: ", values
    ##print "Values[0] = ", type(values[0]),values[0]
    base_value = values[0]
    
    values = values / int(base_value)
    ##print "normalized values", values
    return values


def main_program():
    print "Top of main"

    command_line_args = read_command_line()
    
    dt_start = dt.datetime(2010, 1, 1)
    dt_end = dt.datetime(2010, 12, 31)
    
    ldt_timestamps = get_timestamp_array(dt_start, dt_end)
    print "Timestamps", ldt_timestamps

    quote_df = get_quote_df(ldt_timestamps, [command_line_args[1]])
    print "Quote Array: ", quote_df

    rolling_mean  = pd.rolling_mean(quote_df[command_line_args[1]],window=command_line_args[0])
    print "Rolling Mean: ", rolling_mean
    
    rolling_std   = pd.rolling_std(quote_df[command_line_args[1]],window=command_line_args[0])
    print "Rolling std: ", rolling_std
    
    Bollinger_val = ((quote_df[command_line_args[1]] - rolling_mean) / rolling_std)
    print "Boll val: ", Bollinger_val

    print "Boll for 5/21", Bollinger_val.loc[dt.datetime(2010, 5, 21, 16)]

    print "done for now"

    ##holdings_df = get_holdings_array(ldt_timestamps, ls_symbols)
    ##print "Holdings Dataframe: ", holdings_df

    ##populate_holdings_df(holdings_df, trade_df, quote_df, command_line_args[0])
    ##print "Populated Holdings DF: ", holdings_df

    ##cum_val_df = get_cumulative_value_df(ldt_timestamps)

    ##cum_val_df = populate_cumulative_values(cum_val_df, holdings_df, quote_df, ldt_timestamps)
    ##print "Cumulative", cum_val_df

    ##write_time_series(command_line_args[2], cum_val_df)

    ##normalized_values = normalize_df(cum_val_df)

    ##PrintResults(GetAnalytics(normalized_values))

    ##quote_df = get_quote_df(ldt_timestamps, [command_line_args[3]])
    ##print "quote_df for spx: ", quote_df, "Done"
    ##val_ls = quote_df[command_line_args[3]]
    ##print "val_ls is: ", type(val_ls), val_ls, "Done"
    ##values = val_ls.values
    ##print "values is: ", values, "Done"
    
    ##val_df = pd.DataFrame(val_ls, index=ldt_timestamps,  columns=['close'])

    ##normalized_values = normalize_df(val_df)

    ##print "Results for ", command_line_args[3]

    ##PrintResults(GetAnalytics(normalized_values))
    


if __name__ == '__main__':
    main_program()
