import pandas as pd
import re
import numpy as np
import pickle
import joblib
import csv
import string

with open('./model_analisis.pkl', 'rb') as handle:
  model = pickle.load(handle)
with open('./CountVectorizer.pkl', 'rb') as h:
  cvec = pickle.load(h)
with open('./TfidfTransformer1.pkl', 'rb') as t:
  tfid = pickle.load(t)

def CFRP(kalimat):
  kalimat = kalimat.translate(str.maketrans('','',string.punctuation)).lower()
  return kalimat
  

#Filtering
def Filtering(kalimat):
  from Sastrawi.StopWordRemover.StopWordRemoverFactory import StopWordRemoverFactory
  factory = StopWordRemoverFactory()
  stopword = factory.create_stop_word_remover()
  filter = stopword.remove(kalimat)
  return filter
 

#Tokenize
def Tokenize(kalimat):
  token = kalimat.split()
  return token
 

def Steamming(kalimat):
  from Sastrawi.Stemmer.StemmerFactory import StemmerFactory
  factory = StemmerFactory()
  stemmer = factory.create_stemmer()
  toStr = str(kalimat) 
  return stemmer.stem(toStr)



def update():
  df = pd.read_csv("WebMul/public/filesUpload/tes_data.csv")
  cleandata = df['tweet'].apply(CFRP)
  cleandata = df['tweet'].apply(Filtering)
  cleandata = df['tweet'].apply(Steamming)
  transform_cvec = cvec.transform(df['tweet'])
  transform_tfid = tfid.transform(transform_cvec)
  predict_result = model.predict(transform_tfid)
  df['preprocessing'] = cleandata
  df['label']= predict_result
  return df
  

# with open('tes_data.csv','r') as f:
#   reader = csv.reader(f, delimiter='\t')
#   for i,line in enumerate(reader):
#     text = line[0].split(',') [3]
#     CFRP_text = CFRP(text)
#     Filtering_text = Filtering(CFRP_text)
#     Steamming_text=Steamming(Filtering_text)
#     transform_cvec = cvec.transform([text])
#     transform_tfid = tfid.transform(transform_cvec)
#     predict_result = model.predict(transform_tfid)
#     print(Steamming_text,predict_result)
    # with open('./testing result1.csv', 'a',newline='') as f:
    #     writer=csv.writer(f)
    #     writer.writerow([text,Steamming_text , predict_result])