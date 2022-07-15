import snscrape.modules.twitter as sntwitter
import pandas as pd
import predict as predict
import numpy as np
from flask import Flask, jsonify

df = pd.read_csv("./clean_data.csv")

app = Flask(__name__)
@app.route('/trainingDatas')
def index():
    return df.to_json(orient='records')

@app.route('/Prediction')
def index2():
    data = predict.update
    return data

app.run()