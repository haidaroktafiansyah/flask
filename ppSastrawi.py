import numpy as np
import pandas as pd
import string

df = pd.read_csv("./data_omicron.csv")
print(df.head(10))

print('Dataset size:',df.shape)
print('Coloumn size:',df.columns)

df.info()

#CaseFolding, Remove Punc
def CFRP(kalimat):
  kalimat = kalimat.translate(str.maketrans('','',string.punctuation)).lower()
  return kalimat
  # print(kalimat)

df['CFRP'] = df['tweet'].apply(lambda x: CFRP(x))

#Filtering
def Filtering(kalimat):
  from Sastrawi.StopWordRemover.StopWordRemoverFactory import StopWordRemoverFactory
  factory = StopWordRemoverFactory()
  stopword = factory.create_stop_word_remover()
  filter = stopword.remove(kalimat)
  return filter
  # print(filter)

df['Filtering'] = df['CFRP'].apply(lambda x: Filtering(x))

#Tokenize
def Tokenize(kalimat):
  token = kalimat.split()
  return token
  # print(token)

df['Tokenize'] = df['Filtering'].apply(lambda x: Tokenize(x))

def Steamming(kalimat):
  from Sastrawi.Stemmer.StemmerFactory import StemmerFactory
  factory = StemmerFactory()
  stemmer = factory.create_stemmer()
  toStr = str(kalimat) 
  return stemmer.stem(toStr)
  # print(steam)
df['Steaming'] = df['Filtering'].apply(lambda x: Steamming(x))

# print(df.head(5))

extr=df[['date','username','Steaming','label']]
extr.to_csv('./clean_data.csv')