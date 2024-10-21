public class BoothData
{
    public string? BoothNumber { get; set; }
    public string? Step3Data { get; set; }
    public string? Step4Data { get; set; }
    public string? Step5Data { get; set; }

    public void Reset()
    {
        BoothNumber = null;
        Step3Data = null;
        Step4Data = null;
        Step5Data = null;
    }
}
