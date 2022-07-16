import snscrape.modules.twitter as sntwitter
import pandas as pd
import numpy as np
import re
import string
import json
from flask import Flask, jsonify

def deEmojify(text):
    regrex_pattern = re.compile(pattern = "["
        u"\U0001F600-\U0001F64F"  # emoticons
                u"\U0001F300-\U0001F5FF"  # symbols & pictographs
                u"\U0001F680-\U0001F6FF"  # transport & map symbols
                u"\U0001F1E0-\U0001F1FF"  # flags (iOS)
                u"\U00002702-\U000027B0"
                u"\U000024C2-\U0001F251"
                u"\U0001f926-\U0001f937"
                u'\U00010000-\U0010ffff'
                u"\u200d"
                u"\u2640-\u2642"
                u"\u2600-\u2B55"
                u"\u23cf"
                u"\u23e9"
                u"\u231a"
                u"\u3030"
                u"\ufe0f"
    "]+", flags=re.UNICODE)
    return regrex_pattern.sub(r'',text)

def removePunctuation(kalimat):
    
    kalimat = re.sub(r'http\S+', '', kalimat)
    kalimat = kalimat.translate(str.maketrans('','',string.punctuation))
    return kalimat


def Tokenize(kalimat):
  token = kalimat.split()
  return token
  # print(token)


def JoinSc(text):
    text=np.array(text)
    text= ' '.join(text)
    return text


# print(df.head(100))

# for day in range(1,32):
#     until= day+1
#     query = "(#Omicron) lang:id until:2022-02-"+str(until)+" since:2022-02-"+str(day)
def crawls(text):
    query = text
    tweets = []
    limit = 50

    for tweet in sntwitter.TwitterHashtagScraper(query).get_items():
        if len(tweets)==limit:
            break
        else:
            tweets.append([tweet.date, tweet.user.username, tweet.content])
            

    df = pd.DataFrame(tweets, columns=['date','username', 'tweet'])
    df['tweet'] = df['tweet'].apply(lambda x: deEmojify(x))
    df['tweet'] = df['tweet'].apply(lambda x: removePunctuation(x))
    df['tweet'] = df['tweet'].apply(lambda x: Tokenize(x))
    df['tweet'] = df['tweet'].apply(lambda x: JoinSc(x))

    return df

    

# extr=df[['date','username','tweet']]
# extr.to_csv('./tes_data2.csv')